# Video Timer Scheduler

## Overview

Video Timer Scheduler is a web application that allows authenticated users to schedule YouTube videos to play automatically at a specified time while the timer page remains open in the browser.

The project is designed as a learning platform for modern backend, frontend, cloud, and DevOps technologies.

The application demonstrates:

* PHP backend development
* Authentication and session management
* Relational database design
* REST API development
* JavaScript timer processing
* Docker containerization
* Nginx reverse proxy configuration
* AWS ECS deployment
* Terraform Infrastructure as Code
* CI/CD with GitLab Pipelines

## Main Features

### User Management

* User registration
* User login/logout
* Password hashing
* Session-based authentication

### Timer Management

* Create timer
* Edit timer
* Delete timer
* Enable/disable timer
* View active timers

### Video Playback

* Configure YouTube URL
* Configure trigger time
* Automatic playback within the same browser tab
* Embedded YouTube player

### Timer History

* Record execution history
* View previously executed timers
* Store execution timestamps

### Statistics

* Total timers created
* Total executions
* Most frequently executed timer

## Architecture

Browser
→ Nginx
→ PHP Application
→ MySQL Database

AWS Deployment

Internet
→ Application Load Balancer
→ ECS Service
→ Nginx Container
→ PHP-FPM Container
→ RDS MySQL

## Technology Stack

Backend:

* PHP 8.3
* PDO
* Composer

Frontend:

* HTML
* CSS
* JavaScript

Database:

* MySQL

Containers:

* Docker
* Docker Compose

Cloud:

* AWS ECS Fargate
* AWS ECR
* AWS RDS
* AWS Application Load Balancer

Infrastructure:

* Terraform

CI/CD:

* GitLab CI/CD

## Database Schema

users

* id
* email
* password_hash
* created_at

timers

* id
* user_id
* title
* youtube_url
* trigger_time
* recurrence
* enabled
* created_at

timer_executions

* id
* timer_id
* executed_at

## Learning Goals

This project is intended to provide practical experience with:

* Backend development
* Database design
* Authentication
* API development
* Containerization
* Cloud deployment
* Infrastructure as Code
* Continuous Integration
* Continuous Deployment
* Production-ready architecture

## Future Improvements

* WebSocket notifications
* OAuth login
* Multiple action types
* Mobile-friendly UI
* User roles
* Terraform modules
* Monitoring and dashboards
* HTTPS with ACM
* Blue/Green deployments
