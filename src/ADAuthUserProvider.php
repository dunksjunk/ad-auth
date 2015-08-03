<?php namespace dunksjunk\ADAuth;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ADAuthUserProvider implements UserProvider {

  /**
   * Configuration Parameters
   * Can be set in config file 
   *
   * Port will default to '389'
   *
   * @var string
   *
   * Future Expansion: Add encryption option.
   *    - Side Effect: Enabling encryption will change default port to '636'
   *    - Side Effect: Will require SSL Library
   */
  protected $adAuthServer;
  protected $adAuthPort;
  protected $adAuthShortDomain;

  /**
   * From config: Name of eloquent model to return on successful Authentication
   *
   * @var string
   */
  protected $adAuthModel;

  /**
   * From config: List of Active Directory fields to graft onto user object
   *
   * @var array
   */  
  protected $adAuthGraftFields;
  
  /**
   * From config: Auth DB user if user not found on Active Directory
   *
   * @var boolean
   */  
  protected $adAuthDBFallback;
  
  /**
   * From config: If DB user not found, but Active Directory user is, create DB User
   *
   * @var boolean
   */  
  protected $adAuthCreateNew;
  
  /**
   * From config: Field defaults if generating new user
   *
   * @var array
   */  
  protected $adAuthUserDefaults;
	
  /**
   * Server Connection
   *
   * @var resource
   */
  protected $adConnection;


  /**
   * Pull up a new AD User Provider
   * @param none
   */
  public function __construct() {
    $this->adAuthModel = \Config::get('auth.model');
    $this->fetchConfig();
  }

  public function retrieveById($identifier) {
    return $this->createModel()->newQuery()->find($identifier);
  }

  public function retrieveByToken($identifier, $token) {
    $model = $this->createModel();

    return $model->newQuery()
        ->where($model->getKeyName(), $identifier)
        ->where($model->getRememberTokenName(), $token)
        ->first();
  }

  public function updateRememberToken(Authenticatable $user, $token) {
    $user->setRememberToken($token);
    $user->save();
  }

  public function retrieveByCredentials(array $credentials) {
    $query = $this->createModel()->newQuery();

    foreach( $credentials as $key => $value ) {
      if( ! str_contains($key, 'password') ) {
        $query->where($key, $value);
      }
    }

    return $query->first();
  }

  public function validateCredentials(Authenticatable $user, array $credentials) {
    $username = '';
    $password = '';

    // Find a better way to deal with this
    foreach( $credentials as $key => $value ) {
      if( ! str_contains($key, 'password') ) {
        $username = $value;
      } else {
        $password = $value;
      }
    }

    if( $this->adConnection = $this->serverConnect() ) {
      // if it binds, it finds
      $adResult = @ldap_bind($this->adConnection, $this->adAuthShortDomain . '\\' . $username, $password);

        // Grab info here (Future Expansion)

      ldap_unbind($this->adConnection);
      return $adResult;
    } else {
      throw new Exception('Can not connect to Active Directory Server.');
    }

  }

  private function fetchConfig() {
    $this->adAuthServer = \Config::get('adauth.adAuthServer', array('localhost'));
    $this->adAuthPort = \Config::get('adauth.adAuthPort', 389);
    $this->adAuthShortDomain = \Config::get('adauth.adAuthShortDomain', 'mydomain');
    $this->adAuthGraftFields = \Config::get('adauth.adAuthGraftFields', array());
    $this->adAuthDBFallback = \Config::get('adauth.adAuthDBFallback', false);
    $this->adAuthCreateNew = \Config::get('adauth.adAuthCreateNew', false);
    $this->adAuthUserDefaults = \Config::get('adauth.adAuthUserDefaults', array());
    $this->adAuthModel = \Config::get('auth.model', 'App\User');
  }

  private function serverConnect() {
    $adConnectionString = 'ldap://';
    $adConnectionString .= $this->adAuthServer . ':' . $this->adAuthPort . '/';

    $this->adConnection = ldap_connect($adConnectionString);

    ldap_set_option($this->adConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($this->adConnection, LDAP_OPT_REFERRALS, 0);

    return $this->adConnection;
  }

  public function createModel() {
    $class = '\\' . ltrim($this->adAuthModel, '\\');
    return new $class;
  }

}
