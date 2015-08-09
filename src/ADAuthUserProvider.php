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
   * adAuthGraftFields
   * List of Active Directory fields to graft onto user object
   *
   * @var array
   */
  protected $adAuthGraftFields;

  /**
   * adAuthDBFallback
   * Auth DB user if user not found on Active Directory
   *
   * @var boolean
   */
  protected $adAuthDBFallback;

  /**
   * adAuthCreateNew
   * If DB user not found, but Active Directory user is, create DB User
   *
   * @var boolean
   */
  protected $adAuthCreateNew;

  /**
   * adAuthUserDefaults
   * Field defaults if generating new user
   *
   * @var array
   */
  protected $adAuthUserDefaults;

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

  public function updateRememberToken(UserContract $user, $token) {
    $user->setRememberToken($token);
  }

  public function retrieveByCredentials(array $credentials) {
    $query = $this->createModel()->newQuery();
    $usernameField = '';
    $usernameValue = '';

    foreach( $credentials as $key => $value ) {
      if( ! str_contains($key, 'password') ) {
        $usernameField = $key;
        $usernameValue = $value;
        $query->where($usernameField, $usernameValue);
      }
    }

    if ( $this->adAuthCreateNew ) {
      return $query->firstOrNew(array_add($this->adAuthUserDefaults, $usernameField, $usernameValue));
    } else {
      return $query->first();
    }
  }

  public function validateCredentials(UserContract $user, array $credentials) {
    $username = array_first($credentials, function ($key, $value) {
      return $key != 'password';
    });
    $password = array_first($credentials, function ($key, $value) {
      return $key == 'password';
    });

    try {
      $this->adConnection = $this->serverConnect();
      // if it binds, it finds
      $adResult = @ldap_bind($this->adConnection, $this->adAuthShortDomain . '\\' . $username, $password);
        // Grab info here (Future Expansion)
    }
    catch (Exception $e) {
      throw new Exception('Can not connect to Active Directory Server.');
    }

    ldap_unbind($this->adConnection);

    if ($this->adAuthDBFallback && ! $adResult && \Hash::check($password, $user->getAuthPassword())) {
      $adResult = true;
    }
    return $adResult;
  }

  private function fetchConfig() {
    $this->adAuthServer = \Config::get('adauth.adAuthServer', array('localhost'));
    $this->adAuthPort = \Config::get('adauth.adAuthPort', 389);
    $this->adAuthShortDomain = \Config::get('adauth.adAuthShortDomain', 'mydomain');
    $this->adAuthGraftFields = \Config::get('adauth.adAuthGraftFields', []);
    $this->adAuthDBFallback = \Config::get('adauth.adAuthDBFallback', false);
    $this->adAuthCreateNew = \Config::get('adauth.adAuthCreateNew', false);
    $this->adAuthUserDefaults = \Config::get('adauth.adAuthUserDefaults', []);
    $this->adAuthModel = \Config::get('auth.model', 'App\User');
  }

  private function serverConnect() {
    $adConnectionString = '';

    if ( is_array( $this->adAuthServer ) ) {
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

  public function createModel() {
    $class = '\\' . ltrim($this->adAuthModel, '\\');
    return new $class;
  }

}
