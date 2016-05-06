<?php

namespace Weew\HttpClient\Drivers\Curl;

use Weew\Curl\ICurlResource;
use Weew\Curl\ICurlResponseParser;
use Weew\Curl\ResponseParser;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpResponse;
use Weew\Http\IHttpResponse;
use Weew\HttpClient\Drivers\Curl\Exceptions\CurlException;

class ResponseBuilder {
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var mixed
     */
    protected $curlResult;

    /**
     * @var ICurlResponseParser
     */
    protected $parser;

    /**
     * @param $curlResult
     * @param ICurlResource $resource
     * @param ICurlResponseParser $parser
     */
    public function __construct(
        $curlResult,
        ICurlResource $resource,
        ICurlResponseParser $parser = null
    ) {
        $this->curlResult = $curlResult;
        $this->resource = $resource;

        if ( ! $parser instanceof ICurlResponseParser) {
            $parser = new ResponseParser();
        }

        $this->parser = $parser;
    }

    /**
     * @return HttpResponse
     * @throws CurlException
     */
    public function createResponse() {
        $this->checkErrors();

        $headers = $this->parser->getHeaders($this->curlResult);
        $content = $this->parser->getContent($this->curlResult);
        $statusCode = $this->resource->getInfo(CURLINFO_HTTP_CODE);

        $httpResponse = new HttpResponse(
            $statusCode, $content, new HttpHeaders($headers)
        );

        $this->cleanUpResponse($httpResponse);

        return $httpResponse;
    }

    /**
     * @throws CurlException
     */
    protected function checkErrors() {
        if ($this->resource->getErrorCode() !== 0) {
            throw new CurlException(s(
                'Http call %s "%s" resulted in an error. %s.',
                strtoupper($this->resource->getOption(CURLOPT_CUSTOMREQUEST)),
                $this->resource->getInfo(CURLINFO_EFFECTIVE_URL),
                $this->resource->getErrorMessage()
            ));
        }
    }

    /**
     * @param IHttpResponse $httpResponse
     */
    protected function cleanUpResponse(IHttpResponse $httpResponse) {
        // remove this header to be able to return response directly
        // to the browser without causing an error
        $httpResponse->getHeaders()->remove('transfer-encoding');
    }
}
