<?php

namespace Tests\Weew\HttpClient;

use PHPUnit_Framework_TestCase;
use Tests\Weew\HttpClient\Stubs\FakeDriver;
use Weew\Http\HttpRequest;
use Weew\Http\Responses\JsonResponse;
use Weew\HttpClient\JsonClient;

class JsonClientTest extends PHPUnit_Framework_TestCase {
    public function test_send_returns_a_json_response() {
        $client = new JsonClient(new FakeDriver());
        $response = $client->send(new HttpRequest());

        $this->assertTrue($response instanceof JsonResponse);
    }
}
