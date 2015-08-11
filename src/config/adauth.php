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
  'adAuthServer'  => [ 'dc1.mydomain.com', 'dc1.mydomain.com' ],
  'adEncryption'  => 'none',
  'adAuthPort'  => 389,
  'adAuthShortDomain'  => 'mydomain',

  /**
   * If user database record is found, but Active Directory entry is not found,
   * authenticate against password in database (if set). 
   * 
   * Good for that initial Administrator record. 
   */
  'adAuthDBFallback'  => true,
    
];