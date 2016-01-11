<?php

namespace Weew\HttpClient;

use Weew\Http\IHttpRequest;
use Weew\Http\Responses\JsonResponse;

class JsonClient extends HttpClient {
    /**
     * @param IHttpRequest $httpRequest
     *
     * @return JsonResponse
     */
    public function send(IHttpRequest $httpRequest) {
        return JsonResponse::create(parent::send($httpRequest));
    }
}
