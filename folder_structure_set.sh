#!/usr/bin/env bash

set -euo pipefail

PROJECT_NAME="video-timer-scheduler"

echo "Creating project: ${PROJECT_NAME}"

mkdir -p "${PROJECT_NAME}"

cd "${PROJECT_NAME}"

# Application
mkdir -p app
mkdir -p public
mkdir -p src

# Configuration
mkdir -p config

# Database
mkdir -p database/migrations
mkdir -p database/seeds

# Docker
mkdir -p docker/nginx
mkdir -p docker/php

# Terraform
mkdir -p terraform/environments/dev
mkdir -p terraform/environments/prod
mkdir -p terraform/modules

# Documentation
mkdir -p docs

# GitLab CI
touch .gitlab-ci.yml

# Basic files
touch README.md
touch .gitignore

# Application placeholders
touch public/index.php
touch src/.gitkeep

# Config placeholders
touch config/app.php
touch config/database.php

# Database placeholders
touch database/migrations/.gitkeep
touch database/seeds/.gitkeep

# Docker placeholders
touch docker/nginx/default.conf
touch docker/php/Dockerfile

# Terraform placeholders
touch terraform/main.tf
touch terraform/variables.tf
touch terraform/outputs.tf
touch terraform/providers.tf

echo "Project structure created successfully."
