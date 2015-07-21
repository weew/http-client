<?php

namespace Tests\Weew\HttpClient\Drivers;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\HttpClient\Drivers\Curl\CurlResourceWrapper;
use Weew\Url\Url;

class CurlResourceWrapperTest extends PHPUnit_Framework_TestCase {
    public function test_create_curl_header() {
        $wrapper = new CurlResourceWrapper();
        $this->assertEquals('foo: bar', $wrapper->createCurlHeader('foo', 'bar'));
    }

    public function test_create_curl_headers() {
        $wrapper = new CurlResourceWrapper();
        $this->assertEquals(
            ['foo: bar', 'bar: foo'],
            $wrapper->createCurlHeaders(['foo' => 'bar', 'bar' => 'foo'])
        );
    }

    public function test_create_basic_auth_header() {
        $wrapper = new CurlResourceWrapper();
        $this->assertEquals(
            'Authorization: Basic xx',
            $wrapper->createBasicAuthHeader('xx')
        );
    }

    public function test_create_url() {
        $url = new Url('http://localhost:2000?foo=bar');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $wrapper = new CurlResourceWrapper(null, $request);
        $this->assertEquals(
            $url->toString(), $wrapper->createUrl()
        );

        $request->getUrl()->getSegments()->getQuery()->set('yolo', 'swag');
        $this->assertEquals(
            $url->toString(),
            $wrapper->createUrl()
        );
    }
}
