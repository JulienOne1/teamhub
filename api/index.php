<?php

// Initialize SQLite database
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
    chmod($dbPath, 0755);
    
    // Bootstrap Laravel
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Run migrations with seed
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
}

// Forward to Laravel
require __DIR__.'/../public/index.php';