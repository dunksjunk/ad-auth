# ADAuth

[![Supported Laravel Version][laravel-version]][link-laravel]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-build-status]][link-build-status]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Software License][ico-license]](LICENSE.md)

A Laravel 5.0/5.1 package to add Active Directory authentication and local database user mapping.

This tool is optimized and set up for authentication against Microsoft Active Directory Services.


## Install

Via Composer:

``` bash
$ composer require "dunksjunk/ad-auth":"dev-master"
```
dev-master should always work for the currently released Laravel version.

Next add the service provider to the providers section in /config/app.php:

``` bash
dunksjunk\ADAuth\ADAuthServiceProvider
```

Then, in your Laravel App root directory:

``` bash
$ php artisan vendor:publish --provider="dunksjunk\ADAuth\ADAuthServiceProvider"
```
This will place an adauth.php file in your config directory.

Edit config/adauth.php with your domain information and other settings.

Finally, modify /config/auth.php to use the ADAuth driver:

``` bash
'driver' => 'ads',
```


## Usage

Generally, just drop it in, set your options and go.

If using the SSL option and you are having problems, you may need to all the line 'TLS_REQCERT allow' to your LDAP.conf file for php. There's articles everywhere on it.

Typically, regular connections are on port 389, and SSL connections are on 636.


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## About Dunk's Junk

Most things I publish are tools and routines I use on various projects myself. Where there may be many other versions, I put out one that works for me better, or so I can learn. If you can make use of my junk, have at it. If it works good for you, let me know.

If you can find a better way of doing something, I'm all ears and will give careful consideration to whatever suggestions come by.

I just want to make good, solid, and simple tools that are easy to set up and use quickly. Just enough flexibility to fit well, but not so much that the tool itself gets bloated.


## Credits

- [Rich Dunkel][link-author]


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[laravel-version]: https://img.shields.io/badge/Laravel-5-blue.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/dunksjunk/ad-auth.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-build-status]: https://img.shields.io/scrutinizer/build/g/dunksjunk/ad-auth.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dunksjunk/ad-auth.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dunksjunk/ad-auth.svg?style=flat-square

[link-laravel]: http://laravel.com/
[link-packagist]: https://packagist.org/packages/dunksjunk/ad-auth
[link-scrutinizer]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth/code-structure
[link-build-status]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth/build-status/master
[link-code-quality]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth
[link-author]: https://github.com/dunksjunk
