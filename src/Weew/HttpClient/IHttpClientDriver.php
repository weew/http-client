<?php

namespace Weew\HttpClient;

use Weew\Http\IHttpRequest;
use Weew\Http\IHttpResponse;

interface IHttpClientDriver {
    /**
     * @param IHttpClientOptions $options
     * @param IHttpRequest $httpRequest
     *
     * @return IHttpResponse
     */
    function send(IHttpClientOptions $options, IHttpRequest $httpRequest);
}
