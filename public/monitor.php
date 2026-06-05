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
    <title>Timer Monitor</title>

    <meta charset="UTF-8">

    <script>
        let triggeredTimers = [];

        function checkTimers() {

            const now = new Date();

            document
                .querySelectorAll('[data-trigger]')
                .forEach(timer => {

                    const timerId =
                        timer.dataset.id;

                    if (
                        triggeredTimers.includes(
                            timerId
                        )
                    ) {
                        return;
                    }

                    const triggerTime =
                        new Date(
                            timer.dataset.trigger
                        );

                    if (now >= triggerTime) {

                        triggeredTimers.push(
                            timerId
                        );

                        window.location.href =
                            'play-video.php?url=' +
                            encodeURIComponent(
                                timer.dataset.url
                            );
                    }
                });
        }

        setInterval(
            checkTimers,
            1000
        );

        window.onload = function () {

            checkTimers();

            setInterval(function () {

                document.getElementById(
                    'current-time'
                ).innerText =
                    new Date()
                    .toLocaleString();

            }, 1000);
        };
    </script>

</head>
<body>

<h1>TubeTimer Monitor</h1>

<p>
    Current Time:
    <strong id="current-time">
        Loading...
    </strong>
</p>

<p>
    Keep this tab open.
</p>

<p>
    When a timer reaches its trigger time,
    the video will open automatically.
</p>

<hr>

<h2>Active Timers</h2>

<?php if (count($timers) === 0): ?>

<p>
    No timers configured.
</p>

<?php else: ?>

<table border="1" cellpadding="8">

<tr>
    <th>ID</th>
    <th>YouTube URL</th>
    <th>Trigger Time</th>
</tr>

<?php foreach ($timers as $timer): ?>

<tr
    data-id="<?= (int) $timer['id'] ?>"
    data-url="<?= htmlspecialchars((string) $timer['youtube_url']) ?>"
    data-trigger="<?= htmlspecialchars((string) $timer['trigger_time']) ?>"
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

</tr>

<?php endforeach; ?>

</table>

<?php endif; ?>

<hr>

<p>
    <a href="timers.php">
        Manage Timers
    </a>
</p>

<p>
    <a href="dashboard.php">
        Dashboard
    </a>
</p>

</body>
</html>