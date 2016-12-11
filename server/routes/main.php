<?php

$app->get('/', function () use ($app) {
    echo $app->blade->render('main');
});