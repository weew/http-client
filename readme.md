# HTTP client for PHP

[![Build Status](https://travis-ci.org/weew/php-http-client.svg?branch=master)](https://travis-ci.org/weew/php-http-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/weew/php-http-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/weew/php-http-client/?branch=master)
[![Coverage Status](https://coveralls.io/repos/weew/php-http-client/badge.svg?branch=master&service=github)](https://coveralls.io/github/weew/php-http-client?branch=master)
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
