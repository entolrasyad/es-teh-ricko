<?php
// TEMPORARY MIGRATION ENDPOINT — DELETE AFTER USE
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '1');
set_time_limit(60);

header('Content-Type: text/plain; charset=utf-8');

$secret = 'd5699096881dc81ee1a638f92623f2ef';
if (($_GET['token'] ?? '') !== $secret) {
    http_response_code(403);
    echo "Forbidden\n";
    exit;
}

try {
    define('LARAVEL_START', microtime(true));
    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Step 1: test DB connection
    if (isset($_GET['testdb'])) {
        echo "Config DB host: " . config('database.connections.mysql.host') . "\n";
        echo "Config DB port: " . config('database.connections.mysql.port') . "\n";
        echo "Config DB name: " . config('database.connections.mysql.database') . "\n";
        echo "Config DB user: " . config('database.connections.mysql.username') . "\n";
        echo "SSL_CA env: " . (getenv('MYSQL_ATTR_SSL_CA') ?: '(empty)') . "\n";
        echo "PDO options: " . json_encode(config('database.connections.mysql.options')) . "\n\n";

        echo "Available CA paths:\n";
        foreach ([
            '/etc/pki/tls/certs/ca-bundle.crt',
            '/etc/ssl/certs/ca-certificates.crt',
            '/etc/ssl/cert.pem',
            '/etc/ssl/certs/ca-bundle.crt',
        ] as $p) {
            echo "  " . ($f = file_exists($p) ? 'EXISTS' : 'missing') . "  $p\n";
        }
        echo "\n";

        $pdo = $app->make('db')->connection()->getPdo();
        echo "DB connection OK\n";
        echo "Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "\n";
        exit;
    }

    // Step 2: choose what to run
    $action = $_GET['action'] ?? 'migrate';
    switch ($action) {
        case 'fresh':   $command = 'migrate:fresh --force'; break;
        case 'seed':    $command = 'db:seed --force'; break;
        case 'menu':    $command = 'db:seed --class=MenuSeeder --force'; break;
        default:        $command = 'migrate --force'; break;
    }

    ob_start();
    $exit = $kernel->call($command);
    $output = ob_get_clean();

    echo "Command: php artisan $command (exit=$exit)\n\n";
    echo $output ?: "(no output)\n";
    echo "\nDone.\n";
} catch (\Throwable $e) {
    http_response_code(500);
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
