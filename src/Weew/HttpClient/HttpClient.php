<?php

namespace Weew\HttpClient;

use Weew\HttpClient\Drivers\Curl\CurlHttpClientDriver;
use Weew\Http\IHttpRequest;
use Weew\Http\IHttpResponse;

class HttpClient implements IHttpClient {
    /**
     * @var IHttpClientDriver
     */
    private $driver;

    /**
     * @var IHttpClientOptions
     */
    private $options;

    /**
     * @param IHttpClientDriver $driver
     * @param IHttpClientOptions $options
     */
    public function __construct(IHttpClientDriver $driver = null, IHttpClientOptions $options = null) {
        if ($driver === null) {
            $driver = $this->createDriver();
        }

        if ($options === null) {
            $options = $this->createOptions();
        }

        $this->driver = $driver;
        $this->options = $options;
    }

    /**
     * @param IHttpRequest $httpRequest
     *
     * @return IHttpResponse
     */
    public function send(IHttpRequest $httpRequest) {
        return $this->getDriver()->send($this->getOptions(), $httpRequest);
    }

    /**
     * @return IHttpClientDriver
     */
    public function getDriver() {
        return $this->driver;
    }

    /**
     * @return IHttpClientOptions
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @return CurlHttpClientDriver
     */
    protected function createDriver() {
        return new CurlHttpClientDriver();
    }

    /**
     * @return HttpClientOptions
     */
    protected function createOptions() {
        return new HttpClientOptions();
    }

    /**
     * @param bool|true $value
     */
    public function followRedirects($value = true) {
        $this->getOptions()->set(HttpClientOptions::FOLLOW_REDIRECT, $value);
    }

    /**
     * @param bool|true $value
     *
     * @return mixed
     */
    public function verifySSL($value = true) {
        $this->getOptions()->set(HttpClientOptions::VERIFY_SSL, $value);
    }
}
