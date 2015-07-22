<?php

namespace Weew\HttpClient;

use Weew\Http\IHttpRequest;
use Weew\Http\IHttpResponse;

interface IHttpClient {
    /**
     * @param IHttpRequest $httpRequest
     *
     * @return IHttpResponse
     */
    function send(IHttpRequest $httpRequest);

    /**
     * @return IHttpClientOptions
     */
    function getOptions();

    /**
     * @param bool|true $value
     */
    function followRedirects($value = true);

    /**
     * @param bool|true $value
     *
     * @return mixed
     */
    function verifySSL($value = true);
}
