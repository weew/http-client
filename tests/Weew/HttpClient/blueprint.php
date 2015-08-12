<?php

use Weew\Http\Cookie;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\HttpBlueprint\Blueprint;
use Weew\HttpBlueprint\BlueprintProxy;

require __DIR__.'/../../../vendor/autoload.php';

$blueprint = new Blueprint();
$blueprint
    ->get('/', new HttpResponse(HttpStatusCode::OK, 'bar'))
    ->post('post', function() {
        $response = new HttpResponse(
            HttpStatusCode::BAD_REQUEST,
            array_get($_POST, 'value')
        );

        return $response;
    })
    ->get('headers', function() {
        $response = new HttpResponse();
        $response->getHeaders()->set('header', array_get($_SERVER, 'HTTP_HEADER'));
        $response->getHeaders()->set('yolo', 'swag');
        $response->getHeaders()->add('foo', 'foo');
        $response->getHeaders()->add('foo', 'bar');

        return $response;
    })
    ->get('cookies', function() {
        $response = new HttpResponse();
        $response->getCookies()->add(new Cookie('foo', array_get($_COOKIE, 'foo')));
        $response->getCookies()->add(new Cookie('bar', array_get($_COOKIE, 'bar')));
        $response->getCookies()->add(new Cookie('yolo', 'swag'));

        return $response;
    });

$proxy = new BlueprintProxy();
$proxy->addBlueprint($blueprint);
$proxy->sendResponse();
