<?php

namespace Tests\Weew\HttpClient\Drivers;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\Drivers\Curl\CurlResponseWrapper;

class CurlResponseWrapperTest extends PHPUnit_Framework_TestCase {

    private function getRawResponse() {
        return file_get_contents(__DIR__.'/response');
    }

    private function getHeaders() {
        return [
            'Connection' => 'close',
            'Content-Type' => 'text/xml',
            'Content-Length' => 289
        ];
    }

    public function test_parse_headers() {
        $wrapper = new CurlResponseWrapper(null, null);
        $headers = $wrapper->getHeaders($this->getRawResponse());
        $this->assertEquals($this->getHeaders(), $headers);
    }

    public function test_parse_content() {
        $wrapper = new CurlResponseWrapper(null, null);
        $response = $this->getRawResponse();
        $content = $wrapper->getContent($response);

        $this->assertEquals('foo'.PHP_EOL, $content);

        $response = str_replace('foo'.PHP_EOL, '', $response);
        $content = $wrapper->getContent($response);
        $this->assertEquals('', $content);

        $response = str_replace(PHP_EOL.PHP_EOL, '', $response);
        $content = $wrapper->getContent($response);
        $this->assertEquals('', $content);
    }
}
