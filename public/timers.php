<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../src/TimerRepository.php';

$repository = new TimerRepository();

$timers = $repository->findByUserId(
    (int) $_SESSION['user_id']
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Timers</title>
</head>
<body>

<h1>My Timers</h1>

<p>
    <a href="create-timer.php">
        Create Timer
    </a>
</p>

<table border="1" cellpadding="8">

<tr>
    <th>ID</th>
    <th>YouTube URL</th>
    <th>Trigger Time</th>
    <th>Action</th>
</tr>

<?php foreach ($timers as $timer): ?>

<tr>

<td>
    <?= $timer['id'] ?>
</td>

<td>
    <?= htmlspecialchars($timer['youtube_url']) ?>
</td>

<td>
    <?= htmlspecialchars($timer['trigger_time']) ?>
</td>

<td>
    <a href="delete-timer.php?id=<?= $timer['id'] ?>">
        Delete
    </a>
</td>

</tr>

<?php endforeach; ?>

</table>

<p>
    <a href="dashboard.php">
        Dashboard
    </a>
</p>

</body>
</html>