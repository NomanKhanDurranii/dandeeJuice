<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Hostinger Shared Hosting Entry Point
|--------------------------------------------------------------------------
| Place this file in your public_html/ directory on Hostinger.
| Your Laravel project should be uploaded one level up, e.g.:
|
|   /home/u123456789/dandeeJuice/   ← Laravel project lives here
|   /home/u123456789/public_html/   ← This file goes here
|
*/

$projectRoot = __DIR__ . '/../dandeeJuice';

// Maintenance mode check
if (file_exists($maintenance = $projectRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader
require $projectRoot . '/vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once $projectRoot . '/bootstrap/app.php';

// Tell Laravel that public_html is the public path
$app->bind('path.public', fn() => __DIR__);

$app->handleRequest(Request::capture());
