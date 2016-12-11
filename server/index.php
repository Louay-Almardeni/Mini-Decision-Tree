<?php

include_once('bootstrap.php');

// ----- init slim -----
$app = new \Slim\Slim(['debug' => true]);

// ----- init blade -----
$app->blade = new \knowledgeValues\test\Core\BladeWrapper('views', '../cache', ['app' => $app, 'flash' => $app->view()->getData('flash')]);

$di = new RecursiveDirectoryIterator(__DIR__ . '/routes');
foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
    if (pathinfo($filename, PATHINFO_EXTENSION) == 'php') {
        require $filename;
    }
}

$app->notFound(function () use ($app) {
    $app->redirect('/');
});

// ----- run slim -----
$app->run();