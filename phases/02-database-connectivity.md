# Phase 02 - Database Connectivity

## Objective

The goal of this phase is to connect the application to a relational database.

At the end of this phase you will have:

* MySQL installed
* Application database created
* Dedicated database user
* PDO connection working
* Environment configuration
* First database migration

---

# Learning Goals

By completing this phase you will learn:

* MySQL administration
* Database users and permissions
* PDO fundamentals
* Environment variables
* SQL migrations
* Application-to-database communication

---

# Architecture

Before:

```text
Browser
  ↓
PHP
```

After:

```text
Browser
  ↓
PHP
  ↓
PDO
  ↓
MySQL
```

---

# Database Setup

Login:

```bash
sudo mysql
```

Create database:

```sql
CREATE DATABASE tubetimer;
```

Create user:

```sql
CREATE USER 'tubetimer'@'localhost'
IDENTIFIED BY '1234567';
```

Grant permissions:

```sql
GRANT ALL PRIVILEGES
ON tubetimer.*
TO 'tubetimer'@'localhost';

FLUSH PRIVILEGES;
```

Verify login:

```bash
mysql -u tubetimer -p tubetimer
```

---

# Step 1 - Create Environment File

Create:

```text
.env
```

Content:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=tubetimer
DB_USER=tubetimer
DB_PASSWORD=1234567
```

---

# Step 2 - Update .gitignore

Add:

```text
.env
```

---

# Step 3 - Create Database Class

Create:

```text
src/Database.php
```

Content:

```php
<?php

declare(strict_types=1);

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $env['DB_HOST'],
            $env['DB_PORT'],
            $env['DB_NAME']
        );

        $this->connection = new PDO(
            $dsn,
            $env['DB_USER'],
            $env['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
```

---

# Step 4 - Database Test

Create:

```text
public/db-test.php
```

Content:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

try {
    $database = new Database();

    echo '<h1>Database connection successful</h1>';
} catch (Throwable $e) {
    echo $e->getMessage();
}
```

---

# Step 5 - First Migration

Create:

```text
database/migrations/001_create_users.sql
```

Content:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Execute:

```bash
mysql -u tubetimer -p tubetimer
```

Inside MySQL:

```sql
SOURCE /absolute/path/to/database/migrations/001_create_users.sql;
```

Verify:

```sql
SHOW TABLES;
```

---

# Testing

Start server:

```bash
php -S localhost:8000 -t public
```

Open:

```text
http://localhost:8000/db-test.php
```

Expected:

```text
Database connection successful
```

---

# Deliverables

Files created:

```text
.env
src/Database.php
public/db-test.php
database/migrations/001_create_users.sql
```

---

# Commit

```bash
git add .
git commit -m "Add database connectivity"
```

Optional tag:

```bash
git tag phase-02-database
```

---

# Definition of Done

Phase 02 is complete when:

* MySQL is installed
* Database exists
* User exists
* Login works
* PDO connection works
* Users table exists

---

# Next Phase

Phase 03 - Authentication
