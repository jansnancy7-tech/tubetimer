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

# Project Structure

```text
src/
├── UserRepository.php
└── Auth.php

public/
├── register.php
├── login.php
├── logout.php
└── dashboard.php

database/
└── migrations/
    └── 001_create_users.sql
```

---

# Existing Database Schema

The users table was created during Phase 02.

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Verify:

```sql
SHOW TABLES;
DESCRIBE users;
```

Expected:

```text
users
```

Columns:

```text
id
email
password_hash
created_at
```

---

# Step 1 - Create User Repository

Create:

```text
src/UserRepository.php
```

Purpose:

* Create users
* Find users by email
* Encapsulate database access

Methods:

```php
create()
findByEmail()
```

---

# Step 2 - Create Authentication Service

Create:

```text
src/Auth.php
```

Purpose:

* Register users
* Hash passwords
* Verify passwords
* Manage sessions

Methods:

```php
register()
login()
logout()
isAuthenticated()
```

---

# Step 3 - Create Registration Page

Create:

```text
public/register.php
```

Features:

* Registration form
* Email field
* Password field
* Password hashing
* User creation

Expected result:

```text
User registered successfully
```

---

# Step 4 - Create Login Page

Create:

```text
public/login.php
```

Features:

* Login form
* Credential validation
* Session creation
* Redirect to dashboard

Expected flow:

```text
POST login
    ↓
Credentials valid
    ↓
Session created
    ↓
Dashboard
```

---

# Step 5 - Create Dashboard

Create:

```text
public/dashboard.php
```

Requirements:

* Protected page
* Accessible only to logged-in users

Logic:

```php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
```

Display:

```text
Logged in as:
user@example.com
```

---

# Step 6 - Create Logout Page

Create:

```text
public/logout.php
```

Responsibilities:

* Destroy session
* Redirect to login page

Flow:

```text
Logout
   ↓
Session destroyed
   ↓
Redirect login
```

---

# Security Concepts

## Password Hashing

Store:

```php
password_hash(
    $password,
    PASSWORD_DEFAULT
);
```

Never store:

```text
password123
```

inside the database.

---

## Password Verification

Use:

```php
password_verify(
    $password,
    $storedHash
);
```

---

## Session-Based Authentication

After login:

```php
$_SESSION['user_id']
$_SESSION['email']
```

identify the authenticated user.

---

# Testing Checklist

Start server:

```bash
php -S localhost:8000 -t public
```

---

## Test 1 - Registration

Open:

```text
http://localhost:8000/register.php
```

Create user:

```text
Email:
test@example.com

Password:
password123
```

Expected:

```text
User registered successfully
```

---

## Test 2 - Verify Database

```sql
SELECT id, email, created_at
FROM users;
```

Expected:

```text
1 row returned
```

Verify password hash:

```sql
SELECT password_hash
FROM users;
```

Expected:

```text
$2y$...
```

not the original password.

---

## Test 3 - Login

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

## Test 4 - Protected Route

Open:

```text
http://localhost:8000/dashboard.php
```

Expected:

```text
Dashboard visible
```

---

## Test 5 - Logout

Open:

```text
http://localhost:8000/logout.php
```

Expected:

```text
Redirect to login page
```

Try opening:

```text
/dashboard.php
```

Expected:

```text
Redirect to login page
```

---

# Deliverables

Files created:

```text
src/UserRepository.php
src/Auth.php

public/register.php
public/login.php
public/dashboard.php
public/logout.php
```

Files reused:

```text
src/Database.php
database/migrations/001_create_users.sql
```

---

# Commit

```bash
git add .
git commit -m "Add authentication system"
```

Optional tag:

```bash
git tag phase-03-authentication
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
* Prepare database structure for YouTube scheduling
