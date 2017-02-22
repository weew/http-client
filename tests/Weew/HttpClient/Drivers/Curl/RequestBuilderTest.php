<?php

namespace Tests\Weew\HttpClient\Drivers\Curl;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\RequestBuilder;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Url\Url;

class RequestBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_create_url() {
        $url = new Url('http://localhost:2000?foo=12+34 bar baz');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $builder = new RequestBuilder($request);
        $this->assertEquals(
            'http://localhost:2000?foo=12%2B34%20bar%20baz', $builder->createUrl()
        );
    }
}
