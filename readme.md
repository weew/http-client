# HTTP client for PHP

[![Build Status](https://img.shields.io/travis/weew/http-client.svg)](https://travis-ci.org/weew/http-client)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/http-client.svg)](https://scrutinizer-ci.com/g/weew/http-client)
[![Test Coverage](https://img.shields.io/coveralls/weew/http-client.svg)](https://coveralls.io/github/weew/http-client)
[![Version](https://img.shields.io/packagist/v/weew/http-client.svg)](https://packagist.org/packages/weew/http-client)
[![Licence](https://img.shields.io/packagist/l/weew/http-client.svg)](https://packagist.org/packages/weew/http-client)

## Table of contents
- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Related projects](#related-projects)

## Installation

`composer require weew/http-client`

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

## JsonClient

There is a slightly different implementation of the `HttpClient` that is meant to be used whenever you are sure that you will always receive json responses. `JsonClient` will automatically cast `HttpResponse` to a `JsonResponse`.

```php
$client = new JsonClient();
```

## Related Projects

- [URL](https://github.com/weew/url): used throughout the project.
- [HTTP Layer](https://github.com/weew/http): offers response and request objects,
handles cookies, headers and much more.
