# Laravel Vue Image Manager

[![Laravel](https://github.com/DipaliJadhav/image-upload-app/actions/workflows/laravel.yml/badge.svg)](https://github.com/DipaliJadhav/image-upload-app/actions/workflows/laravel.yml)

A full-stack image management application built with Laravel 12 and Vue 3. Users can upload images, manage their personal gallery, browse a public feed, and perform secure image operations with background processing.

## Features

### Authentication & Authorization
- User registration and login using Laravel Sanctum
- Protected API routes
- Policy-based authorization for image deletion
- Users can only delete their own images

### Image Management
- Upload images with validation
- Delete images
- Personal gallery displaying only the authenticated user's images
- Public feed displaying images from all users
- Paginated image listings

### Background Processing
- Laravel Jobs & Queues
- Asynchronous image processing after upload
- Automatic metadata extraction:
    - File size
    - MIME type
    - Processing status tracking

### API Architecture
- RESTful API endpoints
- Pagination support
- Laravel API Resources for consistent responses

### Testing & CI/CD
- PHPUnit Feature Tests
- Queue Job Tests
- GitHub Actions Continuous Integration

## Tech Stack

### Backend

- Laravel 12
- PHP 8.x
- MySQL
- Laravel Sanctum
- Laravel Queues

### Frontend
- Vue 3
- Tailwind CSS
- Axios

### DevOps
- Git
- GitHub
- GitHub Actions

## Installation
git clone <repository-url>

cd backend-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan storage:link

## Start Queue Worker
php artisan queue:work

## Run Tests
php artisan test

## Project Highlights

This project demonstrates:

- Laravel Sanctum Authentication
- Policy-based Authorization
- File Upload & Storage
- Background Job Processing
- API Resource Transformation
- Pagination
- Automated Testing
- CI/CD with GitHub Actions
- Vue 3 Integration with Laravel