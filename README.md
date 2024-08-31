# Laravel Project Setup

## Overview

This is a Laravel project that includes functionality for managing student records. The project provides features to add, update, and delete student records. It also includes unit tests for verifying the functionality of the StudentController.

## Prerequisites

1. **PHP** (version 8.0 or higher)
2. **Composer** (for managing PHP dependencies)
3. **MySQL** (or any other compatible database)
4. **Node.js** (for running the development server)
5. **npm** (for managing JavaScript dependencies)

## Setup Instructions

### 1. Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/shailendradigarse/teacherPortal.git
cd teacherPortal
```
### 2. Install PHP Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

### Configure Environment Variables

1. **Create the .env File**:

Copy the example environment file to create a new .env file:

```bash
cp .env.example .env
```

2 **Set Up Database Configuration**:

Open the .env file and configure your database settings:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Make sure to replace your_database_name, your_database_username, and your_database_password with your actual database credentials.

4. **Generate Application Key**:
Generate a new application key for the Laravel project:

```bash
php artisan key:generate
```
5. **Run Migrations**:
Run the database migrations to set up the necessary tables:

```bash
php artisan migrate
```
6. **Install Node.js Dependencies**:

Install the Node.js dependencies:

```bash
npm install
```
7. **Run Development Server**:
Start the development server to serve the application:

```bash
npm run dev
```
8. **Start PHP Server**:
Open a new terminal and start the PHP development server:

```bash
php artisan serve
```
The application will be accessible at http://127.0.0.1:8000 (or another port specified in the output).

## Running Tests
### Unit Tests
To run the unit tests, use the following command:

```bash
vendor/bin/phpunit
```
### Code Coverage Report
To generate a code coverage report, use the following command:

```bash
vendor/bin/phpunit --coverage-html coverage
```
This command will create a coverage directory with an HTML report showing the coverage details.

## Summary
Cloned the repository and installed dependencies.
Configured the .env file for database settings.
Generated application key and ran migrations.
Installed Node.js dependencies and started development server.
Ran the PHP server to access the application.
Executed unit tests and generated code coverage report.

