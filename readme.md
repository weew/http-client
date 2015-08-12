# HTTP client for PHP

[![Build Status](https://travis-ci.org/weew/php-http-client.svg?branch=master)](https://travis-ci.org/weew/php-http-client)
[![Code Climate](https://codeclimate.com/github/weew/php-http-client/badges/gpa.svg)](https://codeclimate.com/github/weew/php-http-client)
[![License](https://poser.pugx.org/weew/php-http-client/license)](https://packagist.org/packages/weew/php-http-client)

## Usage

This client is based on [this](https://github.com/weew/php-http) great HTTP layer.

##### Basic example

```php
$client = new HttpClient();
$request = new HttpRequest(
	HttpRequestMethod::GET, new Url('http://google.com')
);
$response = $client->send($request); // returns an HttpResponse
```
