# ADAuth

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-build-status]][link-build-status]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

A Laravel 5.0/5.1 package to add Active Directory authentication and local database user mapping. Optionally, selected LDAP fields can be grafted onto user record. 

This tool is optimized and set up for authentication against Microsoft Active Directory Services. For a general LDAP authenticator, please use (coming soon).

Release version numbers will follow Laravel's versions to keep compatibility straight. So ADAuth v5.* should be compatible with Laravel 5.*, and so on. While I am maintaining this project, I will make a best effort to keep fixes and changes current across all maintained versions. Once a Laravel version expires from general use or goes EOL, so will its ADAuth branch. 

** Pre-release software ** You've been warned.
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

Don't use this yet, it's not ready, at all. 


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## About Dunk's Junk

Most things I publish are tools and routines I use on various projects myself. Many of the offerings out there just don't always fit what I'm doing, or have other problems. 

I just want to make good, solid, simple tools that are easy to set up and use quickly. Just enough flexibility to fit well, but not so much that the tool gets bloated.


## Credits

- [Rich Dunkel][link-author]


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/dunksjunk/ad-auth.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-build-status]: https://img.shields.io/scrutinizer/build/g/dunksjunk/ad-auth.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dunksjunk/ad-auth.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dunksjunk/ad-auth.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/dunksjunk/ad-auth
[link-scrutinizer]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth/code-structure
[link-build-status]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth/build-status/master
[link-code-quality]: https://scrutinizer-ci.com/g/dunksjunk/ad-auth
[link-downloads]: https://packagist.org/packages/dunksjunk/ad-auth
[link-author]: https://github.com/dunksjunk
