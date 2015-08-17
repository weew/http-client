<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Curl\CurlResource;
use Weew\Curl\ICurlResource;
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
    protected $request;

    /**
     * @param IHttpRequest $request
     * @param IHttpClientOptions $options
     * @param ICurlResource $resource
     */
    public function __construct(
        IHttpRequest $request,
        IHttpClientOptions $options = null,
        ICurlResource $resource = null
    ) {
        if ( ! $options instanceof IHttpClientOptions) {
            $options = new HttpClientOptions();
        }

        if ( ! $resource instanceof ICurlResource) {
            $resource = new CurlResource();
        }

        $this->options = $options;
        $this->request = $request;
        $this->resource = $resource;

        $this->build();
    }

    /**
     * Build the request.
     */
    public function build() {
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
            if (str_starts_with($option, 'CURLOPT_') && defined($option)) {
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
