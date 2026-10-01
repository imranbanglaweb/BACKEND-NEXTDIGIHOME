<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$template = App\Models\EmailTemplate::where('slug', 'maintenance-requisition-created')->first();

if ($template) {
    echo 'Found: ' . $template->name . PHP_EOL;
} else {
    echo 'Not found' . PHP_EOL;
}