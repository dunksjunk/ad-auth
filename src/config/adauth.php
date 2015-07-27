<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ADS Authentication SETUP
    |--------------------------------------------------------------------------
    |
    | The ADS Authentication system requires connection info for your Active 
    | Directory Server of choice. 
    | adAuthServer: The FQDN or IP address of your domain controller
    |
    | adAuthPort: Typically 389 on most domain controllers
    |
    | adAuthShortDomain: The first segment of your network domain name. 
    |     ex: 'office' if your domain is office.mydomain.com
    */
    'adAuthServer'  => env('ADS_SERVER', 'dc1.mydomain.com'),
    'adAuthPort'  => env('ADS_PORT', 389),
    'adAuthShortDomain'  => env('ADS_SHORT_DOMAIN', 'mydomain'),

];