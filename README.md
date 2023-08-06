# Laravel Starter API

![Laravel](https://img.shields.io/badge/Laravel-10-brightgreen)
![API](https://img.shields.io/badge/API-Starter-blue)


A simple, easy-to-use starter API template written in Laravel 10. This API is perfect for beginners and can be easily adapted for your project.

## Features

- **Sanctum Authentication**: Secure your application with Laravel's built-in Sanctum authentication.
- **Thumbnail Support:**: Allow users to upload and display profile thumbnails.
- **Custom Middleware**: We provide a custom middleware for different user account types.
- **Protected Routes**: Ensure your application's integrity with out-of-the-box protected routes.
- **Adaptable**: Our template is designed to be adaptable to your project's needs, making it a great starting point for any Laravel application.

## Installation

1. Clone the repository
   First, clone the project from our GitHub repository:
```bash
git clone https://github.com/uvrest/laravel-starter-api.git
```
2. Install dependencies
   Navigate into your new project's directory and install the PHP dependencies:
```bash
cd laravel-starter-api
composer install
```
3. Create the symbolic link for uploading thumbnails
   This will create a symbolic link from `public/storage` to `storage/app/public`, allowing Laravel to retrieve uploaded files.
```bash
php artisan storage:link
```
