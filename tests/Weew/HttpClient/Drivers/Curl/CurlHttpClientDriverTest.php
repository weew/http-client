<?php

namespace Tests\Weew\HttpClient\Drivers\Curl;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\CurlHttpClientDriver;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Http\HttpStatusCode;
use Weew\HttpBlueprint\BlueprintServer;
use Weew\HttpClient\HttpClient;
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

    public static function getUrl() {
        return new Url('http://localhost:6435');
    }

    public static function setUpBeforeClass() {
        $blueprintFile = __DIR__.'/../../blueprint.php';
        $url = self::getUrl();
        $server = new BlueprintServer(
            $url->getHost(),
            $url->getPort(),
            $blueprintFile
        );

        self::$blueprintFile = $blueprintFile;
        self::$server = $server;

        $server->start();
    }

    public static function tearDownAfterClass() {
        self::$server->stop();
    }

    public function test_create_client_with_driver() {
        $driver = new CurlHttpClientDriver();
        new HttpClient($driver);
    }

    public function test_send_get_request() {
        $client = new HttpClient();
        $request = new HttpRequest(
            HttpRequestMethod::GET,
            self::getUrl()
        );
        $response = $client->send($request);
        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
        $this->assertEquals('bar', $response->getContent());
    }

    public function test_send_post_request() {
        $client = new HttpClient();

        $url = self::getUrl();
        $url->addPath('post');
        $request = new HttpRequest(HttpRequestMethod::POST, $url);
        $request->getData()->set('value', 'yolo');
        $response = $client->send($request);

        $this->assertEquals(
            HttpStatusCode::BAD_REQUEST, $response->getStatusCode()
        );
        $this->assertEquals('yolo', $response->getContent());
    }

    public function test_send_and_received_headers() {
        $client = new HttpClient();

        $url = self::getUrl();
        $url->addPath('headers');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $request->getHeaders()->set('header', 'foo');
        $response = $client->send($request);

        $this->assertEquals(
            HttpStatusCode::OK, $response->getStatusCode()
        );
        $this->assertEquals(
            'foo', $response->getHeaders()->find('header')
        );
        $this->assertEquals(
            'swag', $response->getHeaders()->find('yolo')
        );
        $this->assertEquals(
            ['foo', 'bar'], $response->getHeaders()->get('foo')
        );
    }

    public function test_send_and_receive_cookies() {
        $client = new HttpClient();

        $url = self::getUrl();
        $url->addPath('cookies');
        $request = new HttpRequest(HttpRequestMethod::GET, $url);
        $request->getCookieJar()->set('foo', 'bar');
        $request->getCookieJar()->set('bar', 'foo');
        $response = $client->send($request);

        $cookie = $response->getCookies()->findByName('yolo');
        $this->assertNotNull($cookie);
        $this->assertEquals(
            'swag', $cookie->getValue()
        );
        $this->assertEquals(
            'bar', $response->getCookies()->findByName('foo')->getValue()
        );
        $this->assertEquals(
            'foo', $response->getCookies()->findByName('bar')->getValue()
        );
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
