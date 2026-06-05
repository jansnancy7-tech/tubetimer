<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../src/TimerRepository.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $repository = new TimerRepository();

        $repository->create(
            (int) $_SESSION['user_id'],
            trim($_POST['youtube_url']),
            $_POST['trigger_time']
        );

        $message = 'Timer created';
    } catch (Throwable $e) {
        $message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Timer</title>
</head>
<body>

<h1>Create Timer</h1>

<form method="post">

    <label>YouTube URL</label>
    <br>
    <input
        type="url"
        name="youtube_url"
        required
        style="width:500px"
    >

    <br><br>

    <label>Trigger Time</label>
    <br>
    <input
        type="datetime-local"
        name="trigger_time"
        required
    >

    <br><br>

    <button type="submit">
        Create Timer
    </button>

</form>

<p><?= htmlspecialchars($message) ?></p>

<p>
    <a href="timers.php">
        View Timers
    </a>
</p>

<p>
    <a href="dashboard.php">
        Dashboard
    </a>
</p>

</body>
</html>