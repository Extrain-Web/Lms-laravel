<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $dbPath = database_path('database.sqlite');
    echo "DB Path: $dbPath\n";
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("PRAGMA journal_mode = WAL;");
    $count = $pdo->query("SELECT count(*) FROM courses")->fetchColumn();
    echo "Courses count: $count\n";
    echo "SUCCESS: SQLite database accessible and writable outside sandbox!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
