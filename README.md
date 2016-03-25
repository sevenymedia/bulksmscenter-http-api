# bulksmscenter-http-api

[![Latest Stable Version](https://poser.pugx.org/sevenymedia/bulksmscenter-http-api/v/stable.svg)](https://packagist.org/packages/sevenymedia/bulksmscenter-http-api)
[![Latest Unstable Version](https://poser.pugx.org/sevenymedia/bulksmscenter-http-api/v/unstable.svg)](https://packagist.org/packages/sevenymedia/bulksmscenter-http-api)
[![StyleCI](https://styleci.io/repos/53659964/shield?style=flat)](https://styleci.io/repos/53659964)
[![Build Status](https://img.shields.io/travis/sevenymedia/bulksmscenter-http-api.svg)](https://travis-ci.org/sevenymedia/bulksmscenter-http-api)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/3e88b997-922a-4870-8502-6650dd7e647d.svg)](https://insight.sensiolabs.com/projects/3498f336-4466-47c0-9209-87130710af90)
[![Total Downloads](https://img.shields.io/packagist/dt/sevenymedia/bulksmscenter-http-api.svg)](https://packagist.org/packages/sevenymedia/bulksmscenter-http-api)
[![Software License](https://img.shields.io/packagist/l/sevenymedia/bulksmscenter-http-api.svg)](LICENSE.md)

This repository contains an unofficial open source PHP client for the BulkSMSCenter HTTP API

Requirements
-----

- [Get](https://www.bulksmscenter.nl/account/aanmelden/) a free BulkSMSCenter account
- The BulkSMSCenter API client for PHP requires at least PHP 5.4.

Installation
-----

####Composer installation

- [Download composer](https://getcomposer.org/doc/00-intro.md#installation-nix)
- Require this package with composer:
```
composer require sevenymedia/bulksmscenter-http-api
```
- Or add `"sevenymedia/bulksmscenter-http-api": "~1.0"` manually to the `require` section of your `composer.json` and run `composer install`.

```
{
    "require": {
        "sevenymedia/bulksmscenter-http-api": "~1.0"
    }
}
```

####Manual installation

If you do not (want to) use Composer. You can `git clone` or download [this repository](https://github.com/sevenymedia/bulksmscenter-http-api/archive/master.zip) and include the client manually.

Usage
-----

First, set up a `BulkSmsCenter\Client`. Replace YOUR_BULKSMSCENTER_USERNAME and YOUR_BULKSMSCENTER_PASSWORD with your BulkSMSCenter credentials.

```php
require 'bootstrap.php';

$client = new \BulkSmsCenter\Client(new \BulkSmsCenter\Auth(
    'YOUR_BULKSMSCENTER_USERNAME',
    'YOUR_BULKSMSCENTER_PASSWORD'
));
```

You might also need a `BulkSmsCenter\Message`.

```php
$message = new \BulkSmsCenter\Message([
    'body' => 'TEXT_MESSAGE',
    'recipient' => 'RECIPIENT_NUMBER',
    'sender' => 'SENDER_NUMBER',
]);
```

You are now able to connect to the BulkSMSCenter API

```php
// Send a message
$credits = $client->sendMessage($message);

// Get a message status
$credits = $client->getMessageStatus($message->getId());

// Retrieve your remaining credits
$credits = $client->getBalance();
```

## Official Documentation

Documentation for the framework can be found on the [BulkSMSCenter website](https://www.bulksmscenter.nl/informatie/verzendopties/).

## License

This client is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
