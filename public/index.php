<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        echo '<h1>Video Timer Scheduler</h1>';
        echo '<p>Welcome to the project.</p>';
        break;

    default:
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
}
