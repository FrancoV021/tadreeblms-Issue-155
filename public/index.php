<?php

$installedFlag = __DIR__ . '/../installed';

if (!file_exists($installedFlag)) {
    header("Location: install.php");
    exit;
}

define('LARAVEL_START', microtime(true));



// Composer autoload
require __DIR__.'/../vendor/autoload.php';


// Boot Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

$response->send();
$kernel->terminate($request, $response);
