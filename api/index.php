<?php
// 1) Compute a temp storage root in the only writable area:
/** @var string */
$tempStorage = sys_get_temp_dir() . '/storage';

// 2) List the sub-dirs Laravel will need:
$needed = [
    'framework/views',
    'framework/cache',
    'framework/sessions',
    'logs',
];

// 3) Create them if they don’t exist yet:
foreach ($needed as $sub) {
    $path = $tempStorage . DIRECTORY_SEPARATOR . $sub;
    if (! is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

// 4) Tell Laravel (and the view compiler) to use this path:
putenv('LARAVEL_STORAGE_PATH=' . $tempStorage);
putenv('VIEW_COMPILED_PATH='   . $tempStorage . '/framework/views');

// 5) Finally, bootstrap your app as before:
require __DIR__ . '/../public/index.php';