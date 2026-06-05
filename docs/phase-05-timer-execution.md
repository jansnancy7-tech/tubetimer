# Phase 05 - Timer Execution and Video Playback

## Goal

Implement actual timer execution.

Until now, TubeTimer was able to:

* Register users
* Authenticate users
* Create timers
* Store timers in MySQL
* Display timers
* Delete timers

However, timers were only stored and never executed.

This phase introduces a browser-based scheduler that monitors configured timers and automatically opens the configured YouTube video when the scheduled time is reached.

The solution is intentionally browser-driven because the project requirement is:

> Timers should only work while the browser tab is active.

This allows us to avoid background workers, cron jobs, message queues, or scheduled ECS tasks.

---

# Architecture

## Before Phase 05

```text
User
  ↓
Create Timer
  ↓
MySQL
  ↓
Stored Only
```

Timers existed only as records in the database.

No execution logic was present.

---

## After Phase 05

```text
User
  ↓
Create Timer
  ↓
MySQL
  ↓
Monitor Page
  ↓
JavaScript Scheduler
  ↓
Video Playback
```

The monitor page continuously checks pending timers and launches the configured YouTube video when the trigger time is reached.

---

# Features Implemented

## Monitor Page

New page:

```text
public/monitor.php
```

Responsibilities:

* Display active timers
* Continuously monitor timer schedule
* Detect when a timer should execute
* Redirect user to video playback page

The monitor page must remain open.

---

## Video Playback Page

New page:

```text
public/play-video.php
```

Responsibilities:

* Load timer information
* Extract YouTube video identifier
* Mark timer as executed
* Render embedded YouTube player
* Automatically start playback

Playback occurs in the same browser tab.

No popup windows are used.

---

## Timer Execution State

A new database field was introduced:

```sql
executed_at DATETIME NULL
```

Purpose:

* Prevent previously executed timers from running repeatedly
* Maintain execution history
* Provide state tracking

---

# Timer Lifecycle

## Pending

New timer:

```text
executed_at = NULL
```

Example:

```text
Timer ID: 15
Trigger Time: 18:00
Executed At: NULL
```

---

## Executed

When trigger time is reached:

```text
executed_at = 2026-06-05 18:00:01
```

Example:

```text
Timer ID: 15
Trigger Time: 18:00
Executed At: 2026-06-05 18:00:01
```

Executed timers are ignored by the monitor.

---

# Browser Scheduler

The monitor page contains JavaScript that executes every second.

Pseudo workflow:

```text
Load Pending Timers
        ↓
Every Second
        ↓
Check Current Time
        ↓
Compare With Trigger Time
        ↓
Launch Video
```

This scheduler exists only while the browser tab remains open.

---

# Timer Safety Logic

A bug was discovered during implementation.

Original behavior:

```text
Open Monitor
       ↓
Old Timer Found
       ↓
Immediate Playback
```

Because:

```javascript
now >= triggerTime
```

was always true for expired timers.

---

## Solution

Added execution tracking:

```text
executed_at
```

Only timers that satisfy:

```sql
executed_at IS NULL
```

are considered for execution.

This prevents old timers from playing every time the monitor page is opened.

---

# Logging

Timer execution is logged.

Examples:

```text
[INFO] Timer created
[INFO] Timer executed
[INFO] Timer deleted
```

Log file:

```text
logs/app.log
```

This will later integrate nicely with container logging and CloudWatch.

---

# Files Added

```text
public/monitor.php
public/play-video.php
```

---

# Files Modified

```text
src/TimerRepository.php
database/migrations/003_create_timers.sql
```

---

# Manual Testing

## Test 1

Create timer:

```text
Current Time: 12:00
Trigger Time: 12:02
```

Open:

```text
http://localhost:8000/monitor.php
```

Expected:

```text
12:02 reached
      ↓
Redirect
      ↓
play-video.php
      ↓
YouTube Autoplay
```

---

## Test 2

Refresh monitor page after execution.

Expected:

```text
Video does not launch again
```

because:

```text
executed_at IS NOT NULL
```

---

## Test 3

Create multiple timers.

Expected:

```text
All timers appear in monitor page
```

and execute according to schedule.

---

# Lessons Learned

This phase introduced:

* JavaScript scheduling
* Browser-based execution
* State management
* Execution tracking
* YouTube embedding
* Autoplay handling
* Logging
* Debugging time-based applications

These concepts are commonly used in production systems where scheduled tasks, monitoring processes, and state transitions must be managed reliably.

---

# Commit

```text
Implement timer execution and video playback
```

---

# Next Phase

Phase 06 - Dockerization

Goals:

* Containerize application
* Run Nginx in Docker
* Run PHP-FPM in Docker
* Run MySQL in Docker
* Introduce Docker Compose
* Prepare application for ECS deployment

```
```
