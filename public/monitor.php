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

$timers = $repository->findPendingByUserId(
    (int) $_SESSION['user_id']
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Timer Monitor</title>

    <script>

        function checkTimers()
        {
            const now = new Date();

            document
                .querySelectorAll('[data-trigger]')
                .forEach(timer => {

                    const triggerTime =
                        new Date(
                            timer.dataset.trigger
                        );

                    const diffSeconds =
                        (now - triggerTime) / 1000;

                    if (
                        diffSeconds >= 0 &&
                        diffSeconds <= 60
                    ) {

                        window.location.href =
                            'play-video.php' +
                            '?id=' +
                            timer.dataset.id;
                    }
                });
        }

        setInterval(
            checkTimers,
            1000
        );

    </script>
</head>
<body>

<h1>Timer Monitor</h1>

<p>
    Keep this page open.
</p>

<table border="1" cellpadding="8">

<tr>
    <th>ID</th>
    <th>YouTube URL</th>
    <th>Trigger Time</th>
</tr>

<?php foreach ($timers as $timer): ?>

<tr
    data-id="<?= (int) $timer['id'] ?>"
    data-trigger="<?= htmlspecialchars(
        str_replace(
            ' ',
            'T',
            (string) $timer['trigger_time']
        )
    ) ?>"
>

<td>
    <?= (int) $timer['id'] ?>
</td>

<td>
    <?= htmlspecialchars(
        (string) $timer['youtube_url']
    ) ?>
</td>

<td>
    <?= htmlspecialchars(
        (string) $timer['trigger_time']
    ) ?>
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