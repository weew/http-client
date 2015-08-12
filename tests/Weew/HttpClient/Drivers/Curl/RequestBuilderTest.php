<?php

namespace Tests\Weew\HttpClient\Drivers\Curl;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\RequestBuilder;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Url\Url;

class RequestBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_create_url() {
        $url = new Url('http://localhost:2000?foo=bar');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $builder = new RequestBuilder(null, $request);
        $this->assertEquals(
            $url->toString(), $builder->createUrl()
        );
    }
}
