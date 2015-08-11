<?php namespace dunksjunk\ADAuth;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;

class ADAuthUserProvider implements UserProvider {

  /**
   * Configuration Parameters
   */

  /**
   * adAuthServer
   * List of servers to connect to for authentication
   * @var array
   */
    protected $adAuthServer;

  /**
   * adAuthPort
   * Server port. Default 389 or 636 for SSL
   * @var string
   */
  protected $adAuthPort;

  /**
   * adAuthShortDomain
   * For prepending to account name
   * @var string
   */
  protected $adAuthShortDomain;

  /**
   * adAuthModel
   * User Model to return
   * @var string
   */
  protected $adAuthModel;

  /**
   * adAuthDBFallback
   * Auth DB user if user not found on Active Directory
   *
   * @var boolean
   */
  protected $adAuthDBFallback;

  /**
   * Internal Parameters
   */

  /**
   * Server Connection
   *
   * @var resource
   */
  protected $adConnection;


  /**
   * Pull up a new AD User Provider
   */
  public function __construct() {
    $this->adAuthModel = \Config::get('auth.model');
    $this->fetchConfig();
  }

  /**
   * Fetch user from database based on id
   * @param integer
   * @return object
   */
  public function retrieveById($identifier) {
    return $this->createModel()->newQuery()->find($identifier);
  }

  /**
   * Fetch user from database on id & token
   * @param integer
   * @param integer
   * @return object
   */
  public function retrieveByToken($identifier, $token) {
    $model = $this->createModel();

    return $model->newQuery()
        ->where($model->getKeyName(), $identifier)
        ->where($model->getRememberTokenName(), $token)
        ->first();
  }

  /**
   * Set 'remember me' token on user model
   * @param UserContract
   * @param string
   */
  public function updateRememberToken(UserContract $user, $token) {
    $user->setRememberToken($token);
  }

  /**
   * Fetch user from databased on credentials supplied
   * @param array`
   * @return object
   */
  public function retrieveByCredentials(array $credentials) {
    $query = $this->createModel()->newQuery();

    foreach( array_except($credentials, [ 'password' ]) as $key => $value ) {
      $query->where($key, '=', $value);
    }

    return $query->first();
  }

  /**
   * Validate user object based on supplied credentials
   * @param Model
   * @param array
   * @return boolean
   */
  public function validateCredentials(UserContract $user, array $credentials) {
    $username = array_first($credentials, function($key) {
      return $key != 'password';
    });
    $password = array_first($credentials, function($key) {
      return $key == 'password';
    });

    try {
      $this->adConnection = $this->serverConnect();
      // if it binds, it finds
      $adResult = @ldap_bind($this->adConnection, $this->adAuthShortDomain . '\\' . $username, $password);
      ldap_unbind($this->adConnection);
    }catch( Exception $e ) {
      throw new Exception('Can not connect to Active Directory Server.');
    }

    return $this->processResult( $user, $password, $adResult );
  }

   /**
   * Processes Validation and fix results based on options
   * @param UserContract $user
   * @param string $password
   * @param bool $adResult
   * @return bool
   */ 
  private function processResult( UserContract $user, $password, $adResult ) {
    if( $this->adAuthDBFallback && ! $adResult && \Hash::check($password, $user->getAuthPassword()) ) {
      return true;
    }
    return $adResult;
  }
  
  /**
   * Load config files or set defaults
   */
  private function fetchConfig() {
    $this->adAuthServer = \Config::get('adauth.adAuthServer', array('localhost'));
    $this->adAuthPort = \Config::get('adauth.adAuthPort', 389);
    $this->adAuthShortDomain = \Config::get('adauth.adAuthShortDomain', 'mydomain');
    $this->adAuthDBFallback = \Config::get('adauth.adAuthDBFallback', false);
    $this->adAuthModel = \Config::get('auth.model', 'App\User');
  }

  /**
   * Connect to ADS Server or fail
   * @param none
   * @return resource
   */
  private function serverConnect() {
    $adConnectionString = '';

    if( is_array($this->adAuthServer) ) {
      foreach( $this->adAuthServer as $server ) {
        $adConnectionString .= 'ldap://' . $server . ':' . $this->adAuthPort . '/ ';
      }
    } else {
      $adConnectionString = $this->adAuthServer;
    }

    $this->adConnection = ldap_connect($adConnectionString);

    ldap_set_option($this->adConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($this->adConnection, LDAP_OPT_REFERRALS, 0);

    return $this->adConnection;
  }

  /**
   * Create User Model Object
   * @param none
   * @return object
   */
  public function createModel() {
    $class = '\\' . ltrim($this->adAuthModel, '\\');
    return new $class;
  }

}
