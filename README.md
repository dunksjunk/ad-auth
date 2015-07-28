# ADAuth

[![Latest Version on Packagist][ico-version]][link-packagist]

A Laravel 5 package to add Active Directory authentication and optional local database user mapping.

## Install

Via Composer:

``` bash
$ composer require dunksjunk/ad-auth
```

Next add the service provider to the providers section in /config/app.php:

``` bash
dunksjunk\ADAuth\ADAuthServiceProvider
```

Then, in your Laravel App root directory:

``` bash
$ php artisan vendor:publish --provider="dunksjunk\ADAuth\ADAuthServiceProvider"
```

Edit your config file(s) with the proper information. You can use either your .env file or /config/adauth.php:

``` bash
ADS_SERVER=dc1.mydomain.com
ADS_PORT=389
ADS_SHORT_DOMAIN=mydomain
```

Finally, modify /config/auth.php to use the ADAuth driver: 

``` bash
'driver' => 'ads',
```

## Usage

Don't use this yet, it's not ready, at all. 

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Security

If you discover any security related issues, please email richdunkel@gmail.com instead of using the issue tracker.

## Credits

- [Rich Dunkel][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/dunksjunk/ad-auth.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/dunksjunk/ADAuth.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dunksjunk/ADAuth.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dunksjunk/ad-auth.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/dunksjunk/ad-auth
[link-scrutinizer]: https://scrutinizer-ci.com/g/dunksjunk/ADAuth/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/dunksjunk/ADAuth
[link-downloads]: https://packagist.org/packages/dunksjunk/ad-auth
[link-author]: https://github.com/dunksjunk

