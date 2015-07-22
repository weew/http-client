<?php

namespace Tests\Weew\HttpClient\Drivers;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpStatusCode;
use Weew\HttpBlueprint\BlueprintServer;
use Weew\HttpClient\Drivers\Curl\CurlHttpClientDriver;
use Weew\HttpClient\HttpClient;
use Weew\Http\HttpRequestMethod;
use Weew\Http\HttpRequest;
use Weew\Url\Url;

class CurlHttpClientDriverTest extends PHPUnit_Framework_TestCase {
    /**
     * @var BlueprintServer
     */
    public static $server;

    /**
     * @var Url
     */
    public static $url;

    public static $blueprintFile;

    public static function setUpBeforeClass() {
        $blueprintFile = __DIR__.'/../blueprint.php';
        $url = new Url('http://localhost:6435');
        $server = new BlueprintServer(
            $url->getSegments()->getHost(),
            $url->getSegments()->getPort(),
            $blueprintFile
        );

        static::$blueprintFile = $blueprintFile;
        static::$url = $url;
        static::$server = $server;

        $server->start();
    }

    public static function tearDownAfterClass() {
        static::$server->stop();
    }

    public function test_create_client_with_driver() {
        $driver = new CurlHttpClientDriver();
        new HttpClient($driver);
    }

    public function test_send_get_request() {
        $client = new HttpClient();

        $request = new HttpRequest(
            HttpRequestMethod::GET,
            static::$url
        );
        $response = $client->send($request);
        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $request = new HttpRequest(
            HttpRequestMethod::GET,
            static::$url
        );
        $response = $client->send($request);
        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }

    public function test_send_post_request() {
        $client = new HttpClient();

        $url = clone(static::$url);
        $url->getSegments()->addPath('foo');
        $request = new HttpRequest(HttpRequestMethod::POST, $url);
        $response = $client->send($request);

        $this->assertEquals(
            HttpStatusCode::BAD_REQUEST, $response->getStatusCode()
        );
        $this->assertEquals('yolo', $response->getContent());
    }

    public function test_follow_redirects() {
        $client = new HttpClient();
        $url = new Url('http://google.com');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);

        $response = $client->send($request);
        $this->assertTrue($response->isRedirect());

        $client->followRedirects();

        $response = $client->send($request);
        $this->assertTrue($response->isOk());
    }

    public function test_verify_ssl() {
        $client = new HttpClient();
        $client->followRedirects();
        $client->verifySSL(false);

        $url = new Url('https://google.com');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);

        $response = $client->send($request);
        $this->assertTrue($response->isOk());
    }

    public function test_process_raw_options() {
        $client = new HttpClient();
        $url = new Url('http://google.com');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);

        $response = $client->send($request);
        $this->assertTrue($response->isRedirect());


        $client->getOptions()->set('CURLOPT_FOLLOWLOCATION', true);

        $response = $client->send($request);
        $this->assertTrue($response->isOk());
    }
}
