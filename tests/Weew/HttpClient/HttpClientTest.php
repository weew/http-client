<?php

namespace Tests\Weew\HttpClient;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\HttpClient;
use Weew\HttpClient\IHttpClientDriver;
use Weew\HttpClient\IHttpClientOptions;
use Weew\Http\IHttpRequest;

class FakeHttpClientDriver implements IHttpClientDriver {
    function send(IHttpClientOptions $options, IHttpRequest $request) {}
}

class FakeHttpClientOptions implements IHttpClientOptions {
    function get($option, $default = null) {}
    function set($option, $value) {}
    function getAll() {}
    function remove($option) {}
    function has($option) {}
    function merge($options) {}
}

class HttpClientTest extends PHPUnit_Framework_TestCase {
    public function test_create_client() {
        new HttpClient();
    }

    public function test_create_client_with_driver() {
        $driver = new FakeHttpClientDriver();
        $client = new HttpClient($driver);

        $this->assertTrue($client->getDriver() instanceof FakeHttpClientDriver);
    }

    public function test_create_client_with_options() {
        $options = new FakeHttpClientOptions();
        $client = new HttpClient(null, $options);

        $this->assertTrue($client->getOptions() instanceof FakeHttpClientOptions);
    }
}
