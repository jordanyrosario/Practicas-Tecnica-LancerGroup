<?php

declare(strict_types=1);

require __DIR__ . '/vendor/codeigniter4/framework/system/Test/bootstrap.php';

$helperDirs = [
    'vendor/codeigniter4/framework/system/Helpers',
    // 'vendor/tatter/imposter/src/Helpers',
];

foreach ($helperDirs as $dir) {
    $dir = __DIR__ . '/' . $dir;
    chdir($dir);

    foreach (glob('*_helper.php') as $filename) {
        $filePath = realpath($dir . '/' . $filename);

        require_once $filePath;
    }
}