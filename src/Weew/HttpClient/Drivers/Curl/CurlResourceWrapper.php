<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Http\HttpRequest;
use Weew\Http\IHttpRequest;
use Weew\HttpClient\HttpClientOptions;
use Weew\HttpClient\IHttpClientOptions;

class CurlResourceWrapper {
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var IHttpClientOptions
     */
    protected $options;

    /**
     * @var IHttpRequest
     */
    protected $httpRequest;

    /**
     * @param IHttpClientOptions $options
     * @param IHttpRequest $httpRequest
     */
    public function __construct(
        IHttpClientOptions $options = null,
        IHttpRequest $httpRequest = null
    ) {
        if ( ! $options instanceof IHttpClientOptions) {
            $options = new HttpClientOptions();
        }

        if ( ! $httpRequest instanceof IHttpRequest) {
            $httpRequest = new HttpRequest();
        }

        $this->options = $options;
        $this->request = $httpRequest;

        $this->init();
    }

    /**
     * @param $option
     * @param $value
     */
    public function setOption($option, $value) {
        curl_setopt($this->resource, $option, $value);
    }

    /**
     * @return CurlResponseWrapper
     */
    public function exec() {
        $httpResponse = curl_exec($this->resource);

        return new CurlResponseWrapper($this->resource, $httpResponse);
    }

    /**
     * Close resource.
     */
    public function close() {
        curl_close($this->resource);
    }

    /**
     * Initialize a curl resource.
     */
    protected function init() {
        $this->resource = curl_init();
        $this->sendOptions();
        $this->sendHeaders();
        $this->sendContent();
    }

    /**
     * Process and client settings.
     */
    protected function sendOptions() {
        $this->setOption(CURLOPT_URL, $this->createUrl());
        $this->setOption(CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HEADER, true);

        $this->setOption(
            CURLOPT_FOLLOWLOCATION,
            $this->options->get(HttpClientOptions::FOLLOW_REDIRECT, false)
        );

        $this->setOption(
            CURLOPT_SSL_VERIFYPEER,
            $this->options->get(HttpClientOptions::VERIFY_SSL, true)
        );

        foreach ($this->options->getAll() as $option => $value) {
            if (str_starts_with($option, 'CURLOPT_') and defined($option)) {
                $this->setOption(constant($option), $value);
            }
        }
    }

    /**
     * Process and apply request headers.
     */
    protected function sendHeaders() {
        $headers = $this->request->getHeaders()->getAll();
        $curlHeaders = $this->createCurlHeaders($headers);
        $this->setOption(CURLOPT_HTTPHEADER, $curlHeaders);

        if ($this->request->getBasicAuth()->hasBasicAuth()) {
            $basicAuthHeader = $this->createBasicAuthHeader(
                $this->request->getBasicAuth()->getBasicAuthToken()
            );
            $this->setOption(CURLOPT_HTTPHEADER, [$basicAuthHeader]);
        }
    }

    /**
     * Send request content.
     */
    protected function sendContent() {
        $body = null;

        if ($this->request->hasContent()) {
            $body = $this->request->getContent();
        } else if ($this->request->getData()->count() > 0) {
            $body = $this->request->getData()->getDataEncoded();
        }

        if ($body !== null) {
            $this->setOption(CURLOPT_POST, true);
            $this->setOption(CURLOPT_POSTFIELDS, $body);
        }
    }

    /**
     * @return string
     */
    public function createUrl() {
        return $this->request->getUrl()->toString();
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    public function createCurlHeaders(array $headers) {
        $curlHeaders = [];

        foreach ($headers as $key => $value) {
            $curlHeaders[] = $this->createCurlHeader($key, $value);
        }

        return $curlHeaders;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return string
     */
    public function createCurlHeader($key, $value) {
        return s('%s: %s', $key, $value);
    }

    /**
     * @param $token
     *
     * @return string
     */
    public function createBasicAuthHeader($token) {
        return s('Authorization: Basic %s', $token);
    }
}
