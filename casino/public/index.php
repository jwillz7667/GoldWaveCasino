<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

// Error handling configuration
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 'Off');

// Check if vendor autoload exists
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Please run "composer install" in the casino directory first.');
}

// Import required classes
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is maintenance / demo mode via the "down" command we
| will require this file so that any prerendered template can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    /** @var HttpKernel $kernel */
    $kernel = $app->make(HttpKernel::class);

    $request = Request::capture();
    $response = $kernel->handle($request);
    $response->send();

    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    die('Error: ' . $e->getMessage());
}
