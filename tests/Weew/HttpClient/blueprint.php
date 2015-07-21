<?php

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
    });

$client = new BlueprintProxy();
$client->addBlueprint($blueprint);
$client->sendResponse();
