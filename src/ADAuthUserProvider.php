<?php namespace dunksjunk\ADAuth;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class ADAuthUserProvider implements UserProvider {

  /**
   * Configuration Parameters
   * Can be set in config file or .env
   *
   * Port will default to '389'
   *
   * @var string
   *
   * Future Expansion: Add encryption option.
   *    - Side Effect: Enabling encryption will change default port to '636'
   *    - Side Effect: Will require SSL Library
   *
   * Note: User Credentials used for lookup does not need any privileges beyond looking up users.
   *       It would be a wise idea to use a special made user for this purpose.
   */
  protected $adAuthServer;
  protected $adAuthPort;
  protected $adAuthShortDomain;

  /**
   * From config: Name of eloquent model to return on successful Authentication
   *
   * @var string
   */

   /**
   * Server Connection
   *
   * @var LDAP link identifier
   */

  protected $adConnection;


  /**
   * Pull up a new AD User Provider
   * @param none
   */
  public function __construct() {
    $this->fetchConfig();
  }


  public function retrieveById( $identifier ){
    return $this->createModel()->newQuery()->find( $identifier );
  }


  public function retrieveByToken( $identifier, $token ){
    $model = $this->createModel();

    return $model->newQuery()
        ->where( $model->getKeyName(), $identifier )
        ->where( $model->getRememberTokenName(), $token )
        ->first();
  }


  public function updateRememberToken( Authenticatable $user, $token ){
    $user->setRememberToken( $token );
    $user->save();
  }


  public function retrieveByCredentials( array $credentials ){}


  public function validateCredentials( Authenticatable $user, array $credentials ){
    if ( !$this->adConnection = serverConnect() ) {
      throw new Exception( 'Can not connect to Active Directory Server.' );
    }

    // handle the credentials better
    $adResult = ldap_bind( $this->adConnection, $credentials[0], $credentials[1] );
    ldap_close( $this->adConnection );
    return $adResult;
  }


  private function fetchConfig() {
    $this->adAuthServer = \Config::get( 'adauth.adAuthServer' );
    $this->adAuthPort = \Config::get( 'adauth.adAuthPort' );
    $this->adAuthShortDomain = \Config::get( 'adauth.adAuthShortDomain' );
    $this->adAuthModel = \Config::get( 'auth.model' );
  }


  private function serverConnect() {
    $adConnectionString = 'ldap://';
    $adConnectionString .= $this->adAuthServer . ':' . $this->adAuthPort . '/';

    $this->adConnection = ldap_connect( $adConnectionString );

    ldap_set_option( $this->adConnection, LDAP_OPT_PROTOCOL_VERSION, 3 );
    ldap_set_option( $this->adConnection, LDAP_OPT_REFERRALS, 0 );

    return $this->adConnection;
  }


  public function createModel() {
    $class = '\\' . ltrim( $this->model, '\\' );
    return new $class;
  }

}
