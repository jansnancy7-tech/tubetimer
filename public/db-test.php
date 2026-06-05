<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

try {
    $database = new Database();

    echo '<h1>Database connection successful</h1>';
} catch (Throwable $exception) {
    echo '<h1>Connection failed</h1>';
    echo '<pre>';
    echo $exception->getMessage();
    echo '</pre>';
}
