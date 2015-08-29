# HTTP client for PHP

[![Build Status](https://travis-ci.org/weew/php-http-client.svg?branch=master)](https://travis-ci.org/weew/php-http-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/weew/php-http-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/weew/php-http-client/?branch=master)
[![Coverage Status](https://coveralls.io/repos/weew/php-http-client/badge.svg?branch=master&service=github)](https://coveralls.io/github/weew/php-http-client?branch=master)
[![License](https://poser.pugx.org/weew/php-http-client/license)](https://packagist.org/packages/weew/php-http-client)

## Related Projects

[URL](https://github.com/weew/php-url): used throughout the project.

[HTTP Layer](https://github.com/weew/php-http): offers response and request objects,
handles cookies, headers and much more.

## Installation

`composer require weew/php-http-client`

## Sending Requests and receiving Responses

Please check out the HTTP Layer project referenced above, since it does
most of the work and offers a documentation for the underlying HttpRequest and
HttpResponse objects.

This library uses CURL to transfer and receive data.

##### Basic example

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
