<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../src/TimerRepository.php';
require_once __DIR__ . '/../src/Database.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$timerId = (int) ($_GET['id'] ?? 0);

$database = new Database();

$connection = $database->getConnection();

$statement = $connection->prepare(
    'SELECT *
     FROM timers
     WHERE id = :id'
);

$statement->execute([
    'id' => $timerId
]);

$timer = $statement->fetch();

if (!$timer) {
    die('Timer not found');
}

$repository = new TimerRepository();

$repository->markExecuted(
    $timerId
);

$url = $timer['youtube_url'];

parse_str(
    parse_url(
        $url,
        PHP_URL_QUERY
    ) ?? '',
    $query
);

$videoId = $query['v'] ?? null;

if (!$videoId) {
    die('Invalid YouTube URL');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Playing Video</title>

    <style>
        body {
            margin: 0;
            background: #000;
        }

        iframe {
            width: 100vw;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body>

<iframe
    src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>?autoplay=1"
    allow="autoplay"
    allowfullscreen>
</iframe>

</body>
</html>