# HTTP client for PHP

[![Build Status](https://img.shields.io/travis/weew/php-http-client.svg)](https://travis-ci.org/weew/php-http-client)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-http-client.svg)](https://scrutinizer-ci.com/g/weew/php-http-client)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-http-client.svg)](https://coveralls.io/github/weew/php-http-client)
[![Dependencies](https://img.shields.io/versioneye/d/php/weew:php-http-client.svg)](https://versioneye.com/php/weew:php-http-client)
[![Version](https://img.shields.io/packagist/v/weew/php-http-client.svg)](https://packagist.org/packages/weew/php-http-client)
[![Licence](https://img.shields.io/packagist/l/weew/php-http-client.svg)](https://packagist.org/packages/weew/php-http-client)

## Table of contents
- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Related projects](#related-projects)

## Installation

`composer require weew/php-http-client`

## Introduction

Please check out the HTTP Layer project referenced above, since it does most of the work and offers a documentation for the underlying HttpRequest and HttpResponse objects.

This library uses CURL to transfer and receive data.

## Usage

Below is a very basic example on how to use it.

```php
$client = new HttpClient();
$request = new HttpRequest(
    HttpRequestMethod::GET, new Url('http://google.com')
);

// returns an HttpResponse
$response = $client->send($request);

// send response directly to the browser (act like a proxy)
$response->send();
```

## Related Projects

- [URL](https://github.com/weew/php-url): used throughout the project.
- [HTTP Layer](https://github.com/weew/php-http): offers response and request objects,
handles cookies, headers and much more.
