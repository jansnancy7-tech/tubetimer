<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../src/TimerRepository.php';

if (isset($_GET['id'])) {

    $repository = new TimerRepository();

    $repository->delete(
        (int) $_GET['id'],
        (int) $_SESSION['user_id']
    );
}

header('Location: timers.php');

exit;