<?php

use knowledgeValues\services\xml;
use function knowledgeValues\test\Core\F\val;

$app->get('/player', function () use ($app) {
    echo $app->blade->render('player', ['files' => xml\getFileNames()]);
});

$app->get('/player/load-file', function () use ($app) {

    $params = $app->request()->params();

    $file_name = val('file', $params);
    $data = xml\getTree($file_name);

    $app->response()->header('Content-Type', 'application/json;charset=UTF-8');
    echo json_encode(xml\mapping($data));
    
})->name('loadFile');