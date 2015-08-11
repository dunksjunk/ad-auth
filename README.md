# ADAuth

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-build-status]][link-build-status]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

A Laravel 5.0/5.1 package to add Active Directory authentication and local database user mapping.

This tool is optimized and set up for authentication against Microsoft Active Directory Services.

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

Most things I publish are tools and routines I use on various projects myself. Where there may be many other versions, I put out one that works for me better, or so I can learn. I'm putting these projects out there for the public so add another possible tool, or as a learning object. 

If you can find a better way of doing something, I'm all ears and will give careful consideration to whatever suggestions come by.  

I just want to make good, solid, and simple tools that are easy to set up and use quickly. Just enough flexibility to fit well, but not so much that the tool itself gets bloated.


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
