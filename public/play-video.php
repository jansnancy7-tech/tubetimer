<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$url = $_GET['url'] ?? '';

if ($url === '') {
    die('Missing URL');
}

$videoId = null;

parse_str(
    parse_url($url, PHP_URL_QUERY) ?? '',
    $query
);

if (isset($query['v'])) {
    $videoId = $query['v'];
}

if ($videoId === null) {
    die('Invalid YouTube URL');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TubeTimer Player</title>

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
    allow="autoplay; encrypted-media"
    allowfullscreen>
</iframe>

</body>
</html>