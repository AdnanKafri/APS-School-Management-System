<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
$requestedFile = realpath(__DIR__.'/public'.$uri);
$applicationStorage = realpath(__DIR__.'/storage/app/mobile-applications');
if ($requestedFile && $applicationStorage && strpos(str_replace('\\', '/', $requestedFile), str_replace('\\', '/', $applicationStorage).'/') === 0) {
    http_response_code(404);
    return;
}
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/index.php';
