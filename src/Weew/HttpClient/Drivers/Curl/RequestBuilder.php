<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Curl\CurlResource;
use Weew\Curl\ICurlResource;
use Weew\Http\HttpRequest;
use Weew\Http\IHttpRequest;
use Weew\HttpClient\HttpClientOptions;
use Weew\HttpClient\IHttpClientOptions;

class RequestBuilder {
    /**
     * @var ICurlResource
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
     * @param ICurlResource $resource
     */
    public function __construct(
        IHttpClientOptions $options = null,
        IHttpRequest $httpRequest = null,
        ICurlResource $resource = null
    ) {
        if ( ! $options instanceof IHttpClientOptions) {
            $options = new HttpClientOptions();
        }

        if ( ! $httpRequest instanceof IHttpRequest) {
            $httpRequest = new HttpRequest();
        }

        if ( ! $resource instanceof ICurlResource) {
            $resource = new CurlResource();
        }

        $this->options = $options;
        $this->request = $httpRequest;
        $this->resource = $resource;

        $this->setOptions();
        $this->setHeaders();
        $this->setContent();
    }

    /**
     * @return ResponseBuilder
     */
    public function send() {
        $httpResponse = $this->resource->exec();

        return new ResponseBuilder($httpResponse, $this->resource);
    }

    /**
     * Close resource.
     */
    public function close() {
        $this->resource->close();
    }

    /**
     * Process and client settings.
     */
    protected function setOptions() {
        $this->resource->setOption(CURLOPT_URL, $this->createUrl());
        $this->resource->setOption(CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
        $this->resource->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->resource->setOption(CURLOPT_HEADER, true);

        $this->resource->setOption(
            CURLOPT_FOLLOWLOCATION,
            $this->options->get(HttpClientOptions::FOLLOW_REDIRECT, false)
        );

        $this->resource->setOption(
            CURLOPT_SSL_VERIFYPEER,
            $this->options->get(HttpClientOptions::VERIFY_SSL, true)
        );

        foreach ($this->options->toArray() as $option => $value) {
            if (str_starts_with($option, 'CURLOPT_') and defined($option)) {
                $this->resource->setOption(constant($option), $value);
            }
        }
    }

    /**
     * Process and apply request headers.
     */
    protected function setHeaders() {
        $headers = $this->request->getHeaders()->toFlatArray();
        $this->resource->setOption(CURLOPT_HTTPHEADER, $headers);
    }

    /**
     * Send request content.
     */
    protected function setContent() {
        $body = null;

        if ($this->request->hasContent()) {
            $body = $this->request->getContent();
        } else if ($this->request->getData()->count() > 0) {
            $body = $this->request->getData()->getDataEncoded();
        }

        if ($body !== null) {
            $this->resource->setOption(CURLOPT_POST, true);
            $this->resource->setOption(CURLOPT_POSTFIELDS, $body);
        }
    }

    /**
     * @return string
     */
    public function createUrl() {
        return $this->request->getUrl()->toString();
    }
}
