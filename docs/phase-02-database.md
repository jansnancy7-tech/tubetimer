# Phase 02 - Database Connectivity

## Objective

The goal of this phase is to connect the application to a MySQL database and establish the foundation for future features.

At the end of this phase you will have:

* MySQL running locally
* Application database created
* Environment configuration file
* PDO database connection
* Reusable Database class
* Successful connection test
* Initial database schema

---

# Learning Goals

This phase introduces:

* Relational databases
* MySQL administration
* PDO
* Environment variables
* Database abstraction
* SQL schema creation

---

# Architecture

Current:

Browser
→ PHP

After Phase 02:

Browser
→ PHP
→ MySQL

---

# Prerequisites

Verify PHP:

```bash
php -v
```

Verify PDO MySQL extension:

```bash
php -m | grep pdo
```

Expected output:

```text
PDO
pdo_mysql
```

If pdo_mysql is missing, install it before continuing.

---

# Step 1 - Install MySQL

Ubuntu:

```bash
sudo apt update
sudo apt install mysql-server
```

Start service:

```bash
sudo systemctl enable mysql
sudo systemctl start mysql
```

Verify:

```bash
sudo systemctl status mysql
```

---

# Step 2 - Create Database

Login:

```bash
sudo mysql
```

Create database:

```sql
CREATE DATABASE video_timer_scheduler;
```

Create application user:

```sql
CREATE USER 'video_timer'@'localhost'
IDENTIFIED BY 'video_timer_password';
```

Grant permissions:

```sql
GRANT ALL PRIVILEGES
ON video_timer_scheduler.*
TO 'video_timer'@'localhost';

FLUSH PRIVILEGES;
```

Verify:

```sql
SHOW DATABASES;
```

Exit:

```sql
EXIT;
```

---

# Step 3 - Create Environment File

Create:

```text
.env
```

Content:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=video_timer_scheduler
DB_USER=video_timer
DB_PASSWORD=video_timer_password
```

---

# Step 4 - Update .gitignore

Add:

```gitignore
.env
```

Never commit credentials.

---

# Step 5 - Create Database Class

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
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db   = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        $this->connection = new PDO(
            $dsn,
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
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

# Step 6 - Load Environment Variables

Temporary solution:

Update:

```text
public/index.php
```

Add:

```php
<?php

declare(strict_types=1);

$env = parse_ini_file(__DIR__ . '/../.env');

foreach ($env as $key => $value) {
    putenv("$key=$value");
}
```

---

# Step 7 - Test Database Connection

Create:

```text
public/db-test.php
```

Content:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

$env = parse_ini_file(__DIR__ . '/../.env');

foreach ($env as $key => $value) {
    putenv("$key=$value");
}

try {
    $database = new Database();

    echo "Database connection successful";
} catch (Throwable $exception) {
    echo $exception->getMessage();
}
```

---

# Step 8 - Start Application

```bash
php -S localhost:8000 -t public
```

Open:

```text
http://localhost:8000/db-test.php
```

Expected result:

```text
Database connection successful
```

---

# Step 9 - Create First Migration

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

---

# Step 10 - Execute Migration

Login:

```bash
mysql -u video_timer -p video_timer_scheduler
```

Run:

```sql
SOURCE database/migrations/001_create_users.sql;
```

Verify:

```sql
SHOW TABLES;
```

Expected:

```text
users
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

* MySQL is running
* Database exists
* Application user exists
* PDO connection succeeds
* users table exists
* Connection test returns success

---
