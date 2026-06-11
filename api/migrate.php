<?php
// TEMPORARY MIGRATION ENDPOINT — DELETE AFTER USE
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$secret = 'd5699096881dc81ee1a638f92623f2ef';
if (($_GET['token'] ?? '') !== $secret) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$withSeed = isset($_GET['seed']);
$command  = $withSeed ? 'migrate:fresh --seed --force' : 'migrate --force';

ob_start();
$kernel->call($command);
$output = ob_get_clean();

header('Content-Type: text/plain; charset=utf-8');
echo "Command: php artisan $command\n\n";
echo $output ?: "(no output)\n";
echo "\nDone. DELETE api/migrate.php now!\n";
