<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ADS Authentication SETUP
    |--------------------------------------------------------------------------
    |
    | The ADS Authentication system requires connection info for your Active 
    | Directory Server(s) of choice. 
	|
    | adAuthServer: The FQDN or IP address of your domain controller.
	|     Note: array can be any size. connect routine will go down the list
    |           until it connects.
    |
    | adEncryption: Encryption type, if used. 
	|     Choices are: 'none', 'ssl', or 'tls'. Default 'none'.
    |
    |
    | adAuthPort: Typically 389 or 636 on most domain controllers.
    |
    | adAuthShortDomain: The first segment of your network domain name. 
    |     ex: 'office' if your domain is office.mydomain.com
    */
    'adAuthServer'  => array( 'dc1.mydomain.com','dc1.mydomain.com' ),
	'adEncryption'  => 'none',
    'adAuthPort'  => 389,
    'adAuthShortDomain'  => 'mydomain',
	
    /*
    | array of field names from domain account to graft onto user record. 
    |
    | use: user->(field name);
    | NOT IMPLEMENTED YET
    */
  'adAuthGraftFields'  => array(),

    /*
    | If user database record is found, but Active Directory entry is not found,
    | authenticate against password in database (if set). 
    | 
    | Good for that initial Administrator record. 
    | NOT IMPLEMENTED YET
    */
  'adAuthDBFallback'  => true,
	
    /*
    | If user authenticates against Active Directory, but has no database record,
    | create one and move on, if not, fail user authentication.
    | 
    | adAuthUserDefaults: Any default values to insert into new user record. 
    | NOT IMPLEMENTED YET
    */
  'adAuthCreateNew'  => false,
  'adAuthUserDefaults'  => array(),
	
];