# Personal Task Manager

## Student Information
- Project Code: WST21-PM-2026-SF
- Student Name: Kingsly Bryan A. Tan
- Course & Year: BSIT - 2ndyear
- Database Used: MySQL
- Local Environment: XAMPP (Apache and MySQL)

## Features
- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status (Pending / Completed)
- Task description and due date
- Dashboard counters

## Technologies
Laravel, PHP, MySQL, Blade, HTML, CSS

## Setup
1. Install XAMPP and Composer.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and create a database named `task_manager`.
4. Copy `.env.example` to `.env`.
5. Run:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

6. Open `http://127.0.0.1:8000`.

## Laravel Flow
Routes -> Controller -> Model -> Database -> Blade

The `vendor` folder and `.env` file are excluded from GitHub. Composer generates `vendor`, and `.env` contains local configuration.
