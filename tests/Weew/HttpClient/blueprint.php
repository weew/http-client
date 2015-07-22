<?php

use Weew\Foundation\Globals\CookieGlobal;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\HttpBlueprint\Blueprint;
use Weew\HttpBlueprint\BlueprintProxy;

require __DIR__.'/../../../vendor/autoload.php';

$blueprint = new Blueprint();
$blueprint
    ->get('/')
    ->post('foo', function() {
        return new HttpResponse(HttpStatusCode::BAD_REQUEST, 'yolo');
    })
    ->get('cookie', function() {
        $cookie = new CookieGlobal();

        if ($cookie->has('foo')) {
            return new HttpResponse(HttpStatusCode::NO_CONTENT);
        } else {
            $cookie->set('foo', 'bar');
            return new HttpResponse();
        }
    });

$client = new BlueprintProxy();
$client->addBlueprint($blueprint);
$client->sendResponse();
