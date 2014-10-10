[![Latest Stable Version](https://poser.pugx.org/bookability/bookability-php/v/stable.svg)](https://packagist.org/packages/bookability/bookability-php) [![Total Downloads](https://poser.pugx.org/bookability/bookability-php/downloads.svg)](https://packagist.org/packages/bookability/bookability-php) [![Latest Unstable Version](https://poser.pugx.org/bookability/bookability-php/v/unstable.svg)](https://packagist.org/packages/bookability/bookability-php) [![License](https://poser.pugx.org/bookability/bookability-php/license.svg)](https://packagist.org/packages/bookability/bookability-php)

# Bookability

A simple API package for integration with [Bookability](https://www.bookability.io) with PHP 5.3+. If you are looking for our Laravel 4 compatible package, please take a look at https://github.com/bookability/bookability-l4.

## Installation

### Requirements

- Any flavour of PHP 5.3+ should do
- [optional] PHPUnit to execute the test suite


### With Composer

The easiest way to install Bookability is via composer.

In order to install add the following to your `composer.json` file within the `require` block:

	"require": {
		…
		"bookability/bookability-php": "1.*",
		…	
	}

Within Laravel, locate the file `..app/config/app.php` *.

Add the following to the `providers` array:

	'providers' => array(
		…
		'Bookability\BookabilityL4\BookabilityServiceProvider',
		…
	),

Furthermore, add the following the the `aliases` array:

	'aliases' => array(
		…
		'Bookability' => 'Bookability\BookabilityL4\Facades\Bookability',
		…
	),
	
Publish the configuration

	$ php artisan config:publish bookability/bookability-l4

Lastly, run the command `php composer.phar install` command to install it.

### Without Composer

Download the Bookability folder from the repo and save the file into your project path somewhere.

	<?php
	require 'path/to/Bookability.php';

	$bookability = new Bookability();
	$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
	$events = $bookability->events->find();
	
## API

For more information on using the package and API, please refer to [our website](https://www.bookability.io)