# Phase 04 - Timer Management

## Objective

The goal of this phase is to implement the first core feature of TubeTimer.

Authenticated users should be able to:

* Create timers
* View timers
* Delete timers
* Store timer history in MySQL

At the end of this phase, the application becomes a real product instead of just an authentication demo.

---

# Learning Goals

By completing this phase you will learn:

* CRUD operations
* Database relationships
* Foreign keys
* User-owned resources
* Form processing
* Data persistence
* Secure deletion of user data

---

# Application Flow

```text
Login
  ↓
Dashboard
  ↓
Create Timer
  ↓
View Timers
  ↓
Delete Timer
```

---

# Database Design

A user can own many timers.

Relationship:

```text
users
  │
  └───< timers
```

Example:

```text
User:
jansnancy7@gmail.com

Timers:
- Open YouTube at 13:13
- Open YouTube at 18:00
- Open YouTube at 22:30
```

---

# Step 1 - Create Timers Migration

Create:

```text
database/migrations/003_create_timers.sql
```

Content:

```sql
CREATE TABLE timers (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    youtube_url VARCHAR(2048) NOT NULL,

    trigger_time DATETIME NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

---

# Step 2 - Apply Migration

Login:

```bash
mysql -u tubetimer -p tubetimer
```

Execute:

```sql
SOURCE /full/path/to/database/migrations/003_create_timers.sql;
```

Verify:

```sql
SHOW TABLES;
DESCRIBE timers;
```

Expected:

```text
users
timers
```

---

# Step 3 - Create Repository

Create:

```text
src/TimerRepository.php
```

Content:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class TimerRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->getConnection();
    }

    public function create(
        int $userId,
        string $youtubeUrl,
        string $triggerTime
    ): void {
        $statement = $this->connection->prepare(
            'INSERT INTO timers (
                user_id,
                youtube_url,
                trigger_time
            )
            VALUES (
                :user_id,
                :youtube_url,
                :trigger_time
            )'
        );

        $statement->execute([
            'user_id' => $userId,
            'youtube_url' => $youtubeUrl,
            'trigger_time' => $triggerTime
        ]);
    }

    public function findByUserId(
        int $userId
    ): array {
        $statement = $this->connection->prepare(
            'SELECT *
             FROM timers
             WHERE user_id = :user_id
             ORDER BY trigger_time ASC'
        );

        $statement->execute([
            'user_id' => $userId
        ]);

        return $statement->fetchAll();
    }

    public function delete(
        int $timerId,
        int $userId
    ): void {
        $statement = $this->connection->prepare(
            'DELETE FROM timers
             WHERE id = :id
             AND user_id = :user_id'
        );

        $statement->execute([
            'id' => $timerId,
            'user_id' => $userId
        ]);
    }
}
```

---

# Step 4 - Create Timer Page

Create:

```text
public/create-timer.php
```

Purpose:

* Display timer form
* Save timer to database
* Associate timer with logged-in user

Fields:

```text
YouTube URL
Trigger Time
```

---

# Step 5 - Create Timers List Page

Create:

```text
public/timers.php
```

Purpose:

* Display all timers belonging to current user
* Show trigger time
* Show YouTube URL
* Allow timer deletion

Table columns:

```text
ID
YouTube URL
Trigger Time
Actions
```

---

# Step 6 - Create Delete Page

Create:

```text
public/delete-timer.php
```

Purpose:

* Delete timer
* Ensure users can only delete their own timers

Security condition:

```php
WHERE id = :id
AND user_id = :user_id
```

---

# Step 7 - Update Dashboard

Update:

```text
public/dashboard.php
```

Add links:

```text
Create Timer
View Timers
Logout
```

---

# Database Example

After creating a timer:

```text
YouTube URL:
https://www.youtube.com/watch?v=dQw4w9WgXcQ

Trigger Time:
2026-06-06 13:13
```

Database:

```sql
SELECT *
FROM timers;
```

Example:

+----+---------+---------------------------------------------+---------------------+
| id | user_id | youtube_url                                 | trigger_time        |
+----+---------+---------------------------------------------+---------------------+
| 1  | 1       | https://www.youtube.com/watch?v=dQw4w9WgXcQ | 2026-06-06 13:13:00 |
+----+---------+---------------------------------------------+---------------------+

---

# Testing Checklist

Start server:

```bash
php -S localhost:8000 -t public
```

---

## Test 1 - Create Timer

Open:

```text
http://localhost:8000/create-timer.php
```

Create timer:

```text
YouTube URL:
https://www.youtube.com/watch?v=dQw4w9WgXcQ

Trigger Time:
Tomorrow 13:13
```

Expected:

```text
Timer created
```

---

## Test 2 - Verify Database

```sql
SELECT *
FROM timers;
```

Expected:

```text
1 row returned
```

---

## Test 3 - View Timers

Open:

```text
http://localhost:8000/timers.php
```

Expected:

```text
Table contains created timer
```

---

## Test 4 - Delete Timer

Click:

```text
Delete
```

Expected:

```text
Timer removed
```

Verify:

```sql
SELECT *
FROM timers;
```

Expected:

```text
Empty set
```

---

# Deliverables

Files created:

```text
database/migrations/003_create_timers.sql

src/TimerRepository.php

public/create-timer.php
public/timers.php
public/delete-timer.php
```

Files modified:

```text
public/dashboard.php
```

---

# Commit

```bash
git add .
git commit -m "Add timer management"
```

Optional tag:

```bash
git tag phase-04-timer-management
```

---

# Definition of Done

Phase 04 is complete when:

* User can create timers
* Timers are stored in MySQL
* User can view timers
* User can delete timers
* Users only see their own timers

---

# Next Phase

Phase 05 - Timer Execution and Video Playback

Goals:

* Countdown timer
* JavaScript scheduler
* Automatic trigger detection
* Open YouTube video at scheduled time
* Replace current page with embedded YouTube player
* Keep everything inside the same browser tab
* No browser popups required
