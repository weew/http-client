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
    function send(IHttpClientOptions $options, IHttpRequest $httpRequest) {
        $resourceWrapper = new CurlResourceWrapper($options, $httpRequest);
        $responseWrapper = $resourceWrapper->exec();
        $httpResponse = $responseWrapper->createResponse();
        $resourceWrapper->close();

        return $httpResponse;
    }
}
