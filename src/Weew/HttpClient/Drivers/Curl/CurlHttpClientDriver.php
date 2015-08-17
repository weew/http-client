<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Http\IHttpRequest;
use Weew\Http\IHttpResponse;
use Weew\HttpClient\IHttpClientDriver;
use Weew\HttpClient\IHttpClientOptions;

class CurlHttpClientDriver implements IHttpClientDriver {
    /**
     * @param IHttpClientOptions $options
     * @param IHttpRequest $httpRequest
     *
     * @return IHttpResponse
     */
    public function send(IHttpClientOptions $options, IHttpRequest $httpRequest) {
        $requestBuilder = new RequestBuilder($httpRequest, $options);
        $responseBuilder = $requestBuilder->send();
        $httpResponse = $responseBuilder->createResponse();
        $requestBuilder->close();

        return $httpResponse;
    }
}
