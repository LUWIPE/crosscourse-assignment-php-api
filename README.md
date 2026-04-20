# Laravel Event Management System

This is a simple event management system built with Laravel. It allows users to attend events and receive reminders before the event starts.

## Features

- User registration and login
- Event creation and management
- User attendance tracking
- Event reminders via email

## Installation

1. Clone the repository
2. Run `composer install` to install dependencies
3. Run `php artisan migrate` to migrate the database
4. Run `php artisan db:seed` to seed the database with initial data
5. Run `php artisan serve` to start the development server

## Usage

1. Register as a user
2. Create or attend events
3. Receive reminders for upcoming events

## Deploy On Render

If Render shows this error during build:

bash: line 1: composer: command not found

your service is running in the Node runtime. This project must run as a Docker service so PHP and Composer are available.

This repository now includes [Dockerfile](Dockerfile), [.dockerignore](.dockerignore), and [render.yaml](render.yaml).

### Option 1: Blueprint deploy (recommended)

1. In Render, click New and then Blueprint.
2. Connect this repository.
3. Render will read [render.yaml](render.yaml) and create:
	- one web service (Docker runtime)
	- one PostgreSQL database
4. Set required env vars when prompted:
	- APP_KEY
	- APP_URL
	- FRONTEND_URL

### Option 2: Existing service

1. Create a new Web Service in Render.
2. Set Environment to Docker.
3. Deploy from this repository root so Render uses [Dockerfile](Dockerfile).

After first successful deploy, open Render Shell and run:

php artisan migrate --force
php artisan db:seed --force
