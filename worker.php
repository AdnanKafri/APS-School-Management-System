<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
while (true) {
    $kernel->call('queue:work', ['--sleep' =>0.3, '--tries' => 3]);
}