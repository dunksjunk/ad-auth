<?php

return [

  /**
   * --------------------------------------------------------------------------
   * ADS Authentication SETUP
   *--------------------------------------------------------------------------
   *
   * The ADS Authentication system requires connection info for your Active 
   * Directory Server(s) of choice. 
   *
   * adAuthServer: The FQDN or IP address of your domain controller.
   *     Note: array can be any size. connect routine will go down the list
   *           until it connects.
   * 
   * adEncryption: Encryption type, if used. 
   *     Choices are: 'none', 'ssl', or 'tls'. Default 'none'.
   * 
   * 
   *  adAuthPort: Typically 389 or 636 on most domain controllers.
   * 
   *  adAuthShortDomain: The first segment of your network domain name. 
   *      ex: 'office' if your domain is office.mydomain.com
   */
  'adAuthServer'  => [ 'dc1.mydomain.com', 'dc2.mydomain.com' ],
  'adEncryption'  => 'none',
  'adAuthPort'  => 389,
  'adAuthShortDomain'  => 'mydomain',

  /**
   * If active directory doesn't authenticate, due to no user entry or bad
   * password, authenticate against record in database (if present). 
   * 
   * Good for that initial Admin record with no AD counterpart, or backup passwords. 
   */
  'adAuthDBFallback'  => true,
    
];