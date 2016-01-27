<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Curl\ICurlResource;
use Weew\Curl\ICurlResponseParser;
use Weew\Curl\ResponseParser;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpResponse;
use Weew\HttpClient\Exceptions\HostUnreachableException;

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
     * @throws HostUnreachableException
     */
    public function createResponse() {
        $headers = $this->parser->getHeaders($this->response);
        $content = $this->parser->getContent($this->response);
        $statusCode = $this->resource->getInfo(CURLINFO_HTTP_CODE);

        if ($statusCode === 0) {
            $url = $this->resource->getInfo(CURLINFO_EFFECTIVE_URL);

            throw new HostUnreachableException(
                s('Host "%s" is unreachable.', $url)
            );
        }

        $httpResponse = new HttpResponse(
            $statusCode, $content, new HttpHeaders($headers)
        );

        return $httpResponse;
    }
}
