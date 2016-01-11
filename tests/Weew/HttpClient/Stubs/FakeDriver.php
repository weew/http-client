<?php

namespace Tests\Weew\HttpClient\Stubs;

use Weew\Http\HttpResponse;
use Weew\Http\IHttpRequest;
use Weew\HttpClient\IHttpClientDriver;
use Weew\HttpClient\IHttpClientOptions;

class FakeDriver implements IHttpClientDriver {
    public function send(IHttpClientOptions $options, IHttpRequest $httpRequest) {
        return new HttpResponse();
    }
}
