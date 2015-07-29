<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Http\HttpHeaders;
use Weew\Http\HttpResponse;

class CurlResponseWrapper {
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @param $resource
     * @param $response
     */
    public function __construct($resource, $response) {
        $this->resource = $resource;
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return curl_getinfo($this->resource, CURLINFO_HTTP_CODE);
    }

    /**
     * @return HttpResponse
     */
    public function createResponse() {
        $headers = $this->getHeaders($this->response);
        $content = $this->getContent($this->response);

        $httpResponse = new HttpResponse();
        $httpResponse->setStatusCode($this->getStatusCode());
        $httpResponse->setHeaders(new HttpHeaders($headers));
        $httpResponse->setContent($content);

        return $httpResponse;
    }

    /**
     * @param $response
     *
     * @return array
     */
    public function getHeaders($response) {
        $lines = explode(PHP_EOL, $response);

        $headers = [];

        foreach ($lines as $line) {
            if (strpos($line, 'HTTP/') !== false) {
                continue;
            }

            if (strlen($line) == 0) {
                continue;
            }

            if (trim($line) == '') {
                break;
            }

            if (strpos($line, ':') === false) {
                continue;
            }

            list($key, $value) = explode(':', $line, 2);
            $headers[trim($key)] = trim($value);
        }

        return $headers;
    }

    /**
     * @param $response
     *
     * @return string
     */
    public function getContent($response) {
        $lines = explode(PHP_EOL, $response);

        foreach ($lines as $index => $line) {
            if (trim($line) == '') {
                return implode(PHP_EOL, array_slice($lines, $index + 1));
            }
        }

        return '';
    }
}
