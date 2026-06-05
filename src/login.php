<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Auth.php';

$message = '';

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {
    $auth = new Auth();

    if (
        $auth->login(
            trim($_POST['email']),
            $_POST['password']
        )
    ) {
        header(
            'Location: dashboard.php'
        );

        exit;
    }

    $message = 'Invalid credentials';
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

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
        Login
    </button>

</form>

<p>
    <?= htmlspecialchars($message) ?>
</p>

<p>
    <a href="register.php">
        Register
    </a>
</p>

</body>
</html>