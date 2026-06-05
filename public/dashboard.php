<?php

declare(strict_types=1);

session_start();

if (
    !isset($_SESSION['user_id'])
) {
    header(
        'Location: login.php'
    );

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
        <?= htmlspecialchars(
            $_SESSION['email']
        ) ?>
    </strong>
</p>

<p>
    Welcome to TubeTimer.
</p>

<p>
    Timer management
    will be added in Phase 04.
</p>

<p>
    <a href="logout.php">
        Logout
    </a>
</p>

</body>
</html>