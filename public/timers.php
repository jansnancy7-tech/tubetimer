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

<tr
    data-trigger="<?= htmlspecialchars((string) $timer['trigger_time']) ?>"
    data-url="<?= htmlspecialchars((string) $timer['youtube_url']) ?>"
>

<td>
    <?= (int) $timer['id'] ?>
</td>

<td>
    <?= htmlspecialchars((string) $timer['youtube_url']) ?>
</td>

<td>
    <?= htmlspecialchars((string) $timer['trigger_time']) ?>
</td>

<td>
    <a href="delete-timer.php?id=<?= (int) $timer['id'] ?>">
        Delete
    </a>
</td>

</tr>

<?php endforeach; ?>

</table>

<p>
    Browser tab must remain open for timers to trigger.
</p>

<p>
    <a href="dashboard.php">
        Dashboard
    </a>
</p>

</body>
</html>