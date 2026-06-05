<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard</h1>

<p>
    Logged in as:
    <strong>
        <?= htmlspecialchars($_SESSION['email']) ?>
    </strong>
</p>

<ul>
    <li>
        <a href="create-timer.php">
            Create Timer
        </a>
    </li>

    <li>
        <a href="timers.php">
            View Timers
        </a>
    </li>

    <li>
        <a href="logout.php">
            Logout
        </a>
    </li>
</ul>

</body>
</html>