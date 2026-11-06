<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        // Opt-in isolation for fixture suites; never use school storage/config.
        $storage = getenv('ALADHAM_TEST_STORAGE');
        if ($storage !== false && $storage !== '') {
            if (PHP_SAPI !== 'cli' || ($_SERVER['APP_ENV'] ?? '') !== 'testing'
                || ($_SERVER['DB_CONNECTION'] ?? '') !== 'sqlite'
                || ($_SERVER['DB_DATABASE'] ?? '') !== ':memory:'
                || !is_dir($storage)
                || !preg_match('/^aladham-gradebook-2a-[a-f0-9]{32}$/D', basename($storage))) {
                throw new \RuntimeException('Invalid isolated Gradebook test environment.');
            }
            $app->useStoragePath(realpath($storage));
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
