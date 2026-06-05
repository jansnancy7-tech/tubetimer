# Phase 01 - Local Application Bootstrap

## Objective

The goal of this phase is to create the first working version of the application and verify that PHP can run locally.

At the end of this phase you will have:

* Git repository initialized
* Basic project structure
* PHP development environment
* Working homepage
* Basic request handling
* First application commit

---

# Learning Goals

By completing this phase you will learn:

* How PHP applications start
* Project structure fundamentals
* Local development workflow
* HTTP requests and responses
* Basic routing concepts
* Git workflow basics

---

# Project Structure

```text
video-timer-scheduler/
├── public/
│   └── index.php
├── src/
├── config/
├── database/
├── docker/
├── terraform/
├── phases/
├── README.md
└── .gitignore
```

---

# Step 1 - Create Homepage

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
        echo '<h1>TubeTimer</h1>';
        echo '<p>Welcome to the project.</p>';
        break;

    default:
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
}
```

---

# Step 2 - Start PHP Server

Run:

```bash
php -S localhost:8000 -t public
```

---

# Step 3 - Verify Homepage

Open:

```text
http://localhost:8000
```

Expected:

```text
TubeTimer
Welcome to the project.
```

---

# Step 4 - Verify Routing

Open:

```text
http://localhost:8000/?page=home
```

Expected:

```text
TubeTimer
Welcome to the project.
```

---

# Step 5 - Verify 404

Open:

```text
http://localhost:8000/?page=unknown
```

Expected:

```text
404 Not Found
```

---

# Validation

```bash
curl http://localhost:8000
```

```bash
curl "http://localhost:8000/?page=unknown"
```

---

# Deliverables

Files created:

```text
public/index.php
```

---

# Commit

```bash
git add .
git commit -m "Add application bootstrap"
```

Optional tag:

```bash
git tag phase-01-local-app
```

---

# Definition of Done

Phase 01 is complete when:

* PHP runs locally
* Homepage loads
* 404 pages work
* Source code committed

---

# Next Phase

Phase 02 - Database Connectivity
