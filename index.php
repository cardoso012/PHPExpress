<?php

use PHPExpress\PHPExpress;

require __DIR__ . '/vendor/autoload.php';

$app = new PHPExpress();

$app->get('/users/{id}', function ($req, $res) {
    $res->json($req->params);
});

$app->run();
