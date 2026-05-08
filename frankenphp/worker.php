<?php
declare(strict_types=1);

/**
 * FrankenPHP Worker Bootstrap for Laravel
 *
 * This script is loaded ONCE and kept in memory.
 * frankenphp_handle_request() is called in a loop to serve each request
 * without rebooting the application — this is "worker mode".
 *
 * Place the app root path below to match your Laravel installation.
 */

$appBase = '/var/www/i4t-platform';

// Boot the application once
require_once $appBase . '/vendor/autoload.php';

$app = require_once $appBase . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// FrankenPHP worker loop
$handler = static function () use ($kernel): void {
    $request = Illuminate\Http\Request::capture();

    try {
        $response = $kernel->handle($request);
        $response->send();
        $kernel->terminate($request, $response);
    } catch (Throwable $e) {
        // Prevent worker from dying on application exceptions
        error_log((string) $e);
    }

    gc_collect_cycles();
};

while (frankenphp_handle_request($handler)) {
    // Each iteration = one HTTP request handled
}

