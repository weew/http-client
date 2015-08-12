<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Curl\ICurlResource;
use Weew\Curl\ICurlResponseParser;
use Weew\Curl\ResponseParser;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpResponse;

class ResponseBuilder {
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @param $response
     * @param ICurlResource $resource
     * @param ICurlResponseParser $parser
     */
    public function __construct(
        $response,
        ICurlResource $resource,
        ICurlResponseParser $parser = null
    ) {
        $this->response = $response;
        $this->resource = $resource;

        if ( ! $parser instanceof ICurlResponseParser) {
            $parser = new ResponseParser();
        }

        $this->parser = $parser;
    }

    /**
     * @var ICurlResponseParser
     */
    private $parser;

    /**
     * @return HttpResponse
     */
    public function createResponse() {
        $headers = $this->parser->getHeaders($this->response);
        $content = $this->parser->getContent($this->response);

        if (array_get($headers, 'set-cookie')) {
            var_dump($this->response);
            var_dump($headers);
        }

        $httpResponse = new HttpResponse(
            $this->resource->getOption(CURLINFO_HTTP_CODE),
            $content,
            new HttpHeaders($headers)
        );

        return $httpResponse;
    }
}
