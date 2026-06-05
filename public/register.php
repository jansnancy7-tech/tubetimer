<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../config/app.php';

$message = '';

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {
    try {
        $auth = new Auth();

        $auth->register(
            trim($_POST['email']),
            $_POST['password']
        );

        $message =
            'User registered successfully';
    } catch (Throwable $e) {
        $message = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h1>Register</h1>

<form method="post">

    <div>
        <label>Email</label>
        <br>
        <input
            type="email"
            name="email"
            required
        >
    </div>

    <br>

    <div>
        <label>Password</label>
        <br>
        <input
            type="password"
            name="password"
            required
        >
    </div>

    <br>

    <button type="submit">
        Register
    </button>

</form>

<p>
    <?= htmlspecialchars($message) ?>
</p>

<p>
    <a href="login.php">
        Login
    </a>
</p>

</body>
</html>