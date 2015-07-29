<?php

namespace Tests\Weew\HttpClient\Drivers;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\RequestBuilder;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Url\Url;

class RequestBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_create_curl_header() {
        $builder = new RequestBuilder();
        $this->assertEquals('foo: bar', $builder->createCurlHeader('foo', 'bar'));
    }

    public function test_create_curl_headers() {
        $builder = new RequestBuilder();
        $this->assertEquals(
            ['foo: bar', 'bar: foo'],
            $builder->createCurlHeaders(['foo' => 'bar', 'bar' => 'foo'])
        );
    }

    public function test_create_basic_auth_header() {
        $builder = new RequestBuilder();
        $this->assertEquals(
            'Authorization: Basic xx',
            $builder->createBasicAuthHeader('xx')
        );
    }

    public function test_create_url() {
        $url = new Url('http://localhost:2000?foo=bar');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $builder = new RequestBuilder(null, $request);
        $this->assertEquals(
            $url->toString(), $builder->createUrl()
        );

        $request->getUrl()->getSegments()->getQuery()->set('yolo', 'swag');
        $this->assertEquals(
            $url->toString(),
            $builder->createUrl()
        );
    }
}
