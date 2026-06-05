<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

try {
    $database = new Database();
    $connection = $database->getConnection();

    $statement = $connection->query('SELECT NOW() AS current_time');
    $result = $statement->fetch();

    echo '<h1>Database connection successful</h1>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
} catch (Throwable $e) {
    echo '<pre>';
    echo $e->getMessage();
    echo '</pre>';
}