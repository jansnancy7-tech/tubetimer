# Phase 03 - Authentication

## Objective

The goal of this phase is to implement user authentication.

At the end of this phase users will be able to:

* Register
* Login
* Logout
* Access protected pages
* Store passwords securely

This phase introduces the most common authentication mechanisms used by web applications.

---

# Learning Goals

By completing this phase you will learn:

## Password Hashing

Passwords should never be stored in plain text.

Bad:

```text
123456
```

Good:

```text
$2y$10$...
```

PHP provides:

```php
password_hash()
password_verify()
```

for secure password handling.

---

## Sessions

A session allows PHP to remember a user between requests.

Example:

```php
$_SESSION['user_id']
```

---

## Access Control

Protected pages should only be accessible to authenticated users.

Example:

```text
/dashboard.php
```

should require login.

---

# Application Flow

```text
Register
   ↓
Login
   ↓
Dashboard
   ↓
Logout
```

---

# Expected Project Structure

```text
public/
├── index.php
├── register.php
├── login.php
├── logout.php
└── dashboard.php

src/
├── Database.php
├── UserRepository.php
└── Auth.php

database/
└── migrations/
    └── 002_create_users.sql
```

---

# Step 1 - Create Users Migration

Create:

```text
database/migrations/002_create_users.sql
```

Content:

```sql
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Apply migration:

```bash
mysql -u tubetimer -p tubetimer
```

Inside MySQL:

```sql
SOURCE /absolute/path/to/database/migrations/002_create_users.sql;
```

Verify:

```sql
SHOW TABLES;
DESCRIBE users;
```

---

# Step 2 - Create User Repository

Create:

```text
src/UserRepository.php
```

Content:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class UserRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->getConnection();
    }

    public function create(string $email, string $passwordHash): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (email, password_hash)
             VALUES (:email, :password_hash)'
        );

        $statement->execute([
            'email' => $email,
            'password_hash' => $passwordHash
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users
             WHERE email = :email'
        );

        $statement->execute([
            'email' => $email
        ]);

        $user = $statement->fetch();

        return $user ?: null;
    }
}
```

---

# Step 3 - Create Authentication Service

Create:

```text
src/Auth.php
```

Content:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/UserRepository.php';

class Auth
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function register(
        string $email,
        string $password
    ): void {
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $this->users->create(
            $email,
            $passwordHash
        );
    }

    public function login(
        string $email,
        string $password
    ): bool {
        $user = $this->users->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (
            !password_verify(
                $password,
                $user['password_hash']
            )
        ) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        return true;
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function logout(): void
    {
        session_destroy();
    }
}
```

---

# Step 4 - Registration Page

Create:

```text
public/register.php
```

Content:

```php
<?php

session_start();

require_once __DIR__ . '/../src/Auth.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $auth = new Auth();

        $auth->register(
            $_POST['email'],
            $_POST['password']
        );

        $message = 'User registered successfully';
    } catch (Throwable $e) {
        $message = $e->getMessage();
    }
}
?>

<h1>Register</h1>

<form method="post">
    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <button type="submit">
        Register
    </button>
</form>

<p><?= htmlspecialchars($message) ?></p>
```

---

# Step 5 - Login Page

Create:

```text
public/login.php
```

Content:

```php
<?php

session_start();

require_once __DIR__ . '/../src/Auth.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();

    if (
        $auth->login(
            $_POST['email'],
            $_POST['password']
        )
    ) {
        header('Location: dashboard.php');
        exit;
    }

    $message = 'Invalid credentials';
}
?>

<h1>Login</h1>

<form method="post">
    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <button type="submit">
        Login
    </button>
</form>

<p><?= htmlspecialchars($message) ?></p>
```

---

# Step 6 - Dashboard

Create:

```text
public/dashboard.php
```

Content:

```php
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<h1>Dashboard</h1>

<p>
    Logged in as:
    <?= htmlspecialchars($_SESSION['email']) ?>
</p>

<p>
    Timer functionality will be added later.
</p>

<a href="logout.php">
    Logout
</a>
```

---

# Step 7 - Logout

Create:

```text
public/logout.php
```

Content:

```php
<?php

session_start();

session_destroy();

header('Location: login.php');

exit;
```

---

# Testing Checklist

Start server:

```bash
php -S localhost:8000 -t public
```

---

## Registration Test

Open:

```text
http://localhost:8000/register.php
```

Create:

```text
test@example.com
password123
```

Expected:

```text
User registered successfully
```

---

## Database Verification

```sql
SELECT * FROM users;
```

Expected:

```text
1 row
```

Password should appear hashed.

---

## Login Test

Open:

```text
http://localhost:8000/login.php
```

Use:

```text
test@example.com
password123
```

Expected:

```text
Dashboard
Logged in as test@example.com
```

---

## Protected Route Test

Open:

```text
http://localhost:8000/dashboard.php
```

Expected:

```text
Dashboard
```

Logout.

Refresh page.

Expected:

```text
Redirect to login.php
```

---

# Deliverables

Files created:

```text
src/UserRepository.php
src/Auth.php

public/register.php
public/login.php
public/logout.php
public/dashboard.php

database/migrations/002_create_users.sql
```

---

# Commit Plan

Registration:

```bash
git add .
git commit -m "Add user registration"
```

Login:

```bash
git add .
git commit -m "Add user login"
```

Sessions:

```bash
git add .
git commit -m "Add session authentication"
```

---

# Definition of Done

Phase 03 is complete when:

* User can register
* Passwords are hashed
* User can login
* Session persists between requests
* Dashboard is protected
* User can logout

---

# Next Phase

Phase 04 - Timer Management

Goals:

* Create timers
* List timers
* Delete timers
* Store timer history
* Associate timers with users
* Prepare data model for YouTube video scheduling
