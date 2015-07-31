<?php

namespace Tests\Weew\HttpClient;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\CurlHttpClientDriver;
use Weew\HttpClient\HttpClient;
use Weew\HttpClient\HttpClientOptions;

class HttpClientTest extends PHPUnit_Framework_TestCase {
    public function test_create_client() {
        new HttpClient();
    }

    public function test_create_client_with_driver() {
        $driver = new CurlHttpClientDriver();
        $client = new HttpClient($driver);

        $this->assertTrue($client->getDriver() === $driver);
    }

    public function test_create_client_with_options() {
        $options = new HttpClientOptions();
        $client = new HttpClient(null, $options);

        $this->assertTrue($client->getOptions() === $options);
    }
}
