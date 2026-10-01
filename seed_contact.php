<?php

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('db:seed', ['--class' => 'ContactInfoSeeder']);

echo "Seeding completed.\n";