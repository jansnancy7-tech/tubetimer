# Phase 01 - Application Bootstrap

## Objective

The goal of this phase is to create the first working version of the application and verify that PHP can run locally.

At the end of this phase you will have:

* A Git repository initialized
* A basic project structure
* A working PHP homepage
* Simple request routing
* A local development environment using PHP's built-in web server
* Your first application commit

---

# Learning Goals

This phase introduces the following concepts:

## PHP Entry Point

Every web application needs an entry point.

For this project:

```text
public/index.php
```

will be the entry point for all requests.

---

## Basic Routing

Routing determines which code should be executed for a given URL.

Example:

```text
/
```

shows the homepage.

Example:

```text
/?page=home
```

shows the homepage.

Example:

```text
/?page=unknown
```

returns a 404 page.

---

## Local Development

Instead of deploying to AWS immediately, development will be performed locally.

PHP provides a built-in web server that is suitable for development purposes.

---

# Expected Project Structure

```text
video-timer-scheduler/
│
├── public/
│   └── index.php
│
├── src/
├── config/
├── database/
├── docker/
├── terraform/
├── docs/
│
├── README.md
├── .gitignore
└── .gitlab-ci.yml
```

---

# Implementation

## Create Homepage

Create:

```text
public/index.php
```

Content:

```php
<?php

declare(strict_types=1);

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        echo '<h1>Video Timer Scheduler</h1>';
        echo '<p>Welcome to the project.</p>';
        break;

    default:
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
}
```

---

# Running the Application

From the project root:

```bash
php -S localhost:8000 -t public
```

Expected output:

```text
PHP Development Server started
```

---

# Testing

## Homepage

Open:

```text
http://localhost:8000
```

Expected result:

```html
Video Timer Scheduler

Welcome to the project.
```

---

## Route Test

Open:

```text
http://localhost:8000/?page=home
```

Expected result:

```html
Video Timer Scheduler

Welcome to the project.
```

---

## 404 Test

Open:

```text
http://localhost:8000/?page=unknown
```

Expected result:

```html
404 Not Found
```

---

# Validation Commands

Homepage:

```bash
curl http://localhost:8000
```

404 test:

```bash
curl "http://localhost:8000/?page=unknown"
```

---

# What Was Learned

After completing this phase you should understand:

* What a PHP entry point is
* How a request reaches PHP
* Basic routing concepts
* HTTP status codes
* Local PHP development workflow

---

# Deliverables

The following files should exist:

```text
public/index.php
```

The application should be accessible through:

```text
http://localhost:8000
```

---

# Commit

Create the first application commit:

```bash
git add .
git commit -m "Add application bootstrap"
```

Optional tag:

```bash
git tag phase-01-bootstrap
git push origin phase-01-bootstrap
```

---

# Definition of Done

Phase 01 is complete when:

* PHP runs locally
* Homepage is displayed
* Unknown pages return 404
* Source code is committed to Git
* The application can be started using:

```bash
php -S localhost:8000 -t public
```
