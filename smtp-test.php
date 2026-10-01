<?php

$hosts = [
    ['localhost', 25],
    ['nextdigihome.com', 465],
    ['nextdigihome.com', 587],
    ['mail.nextdigihome.com', 465],
    ['mail.nextdigihome.com', 587],
];

foreach ($hosts as $server) {
    $host = $server[0];
    $port = $server[1];

    echo "Testing {$host}:{$port} ... ";

    $fp = @fsockopen($host, $port, $errno, $errstr, 10);

    if ($fp) {
        echo "CONNECTED<br>";
        fclose($fp);
    } else {
        echo "FAILED: {$errstr} ({$errno})<br>";
    }
}