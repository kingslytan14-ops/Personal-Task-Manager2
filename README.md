# Personal Task Manager

## Student Information

* **Project Code:** WST21-PM-2026-SF
* **Student Name:** Kingsly Bryan A. Tan
* **Course & Year:** BSIT - 2nd Year
* **Database Used:** MySQL
* **Local Environment:** XAMPP (Apache and MySQL)

## Project Overview

Personal Task Manager is a Laravel web application for managing personal tasks. The system allows users to add, view, edit, update the status, and delete tasks.

## Features

* Add Task
* View Tasks
* Edit Task
* Delete Task
* Update Status (Pending / Completed)
* Task Description
* Due Date
* Dashboard Counters

## Technologies Used

* Laravel
* PHP
* MySQL
* Blade
* HTML
* CSS
* XAMPP

## How the System Works

### 1. Open the System

The user opens the Personal Task Manager and sees the dashboard and task list.

### 2. Add a Task

The user clicks **Add New Task** and enters the task name, description, status, and due date. After submitting the form, the task is saved in the MySQL database.

### 3. View Tasks

The saved task appears in the task list. The dashboard shows the total, pending, and completed task counters.

### 4. Edit a Task

The user clicks **Edit** and changes the task information. After saving, the updated information is stored in the database.

### 5. Update Status

The user can change the task status between **Pending** and **Completed**.

### 6. Delete a Task

The user can delete a task when it is no longer needed.

## System Flow

```text
User
 ↓
Blade View
 ↓
Route
 ↓
TaskController
 ↓
Task Model
 ↓
MySQL Database
 ↓
Task Model
 ↓
Blade View
 ↓
User
```

## Laravel Code

### 1. Routes

The routes are located in:

```text
routes/web.php
```

Code:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);
```

The resource route creates the routes needed for adding, viewing, editing, updating, and deleting tasks.

### 2. Task Model

The model is located in:

```text
app/Models/Task.php
```

Code:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'status',
        'due_date',
    ];
}
```

The model allows the application to work with the `tasks` table in MySQL.

### 3. Task Controller

The controller is located in:

```text
app/Http/Controllers/TaskController.php
```

Code:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController
{
    public function index()
    {
        $tasks = Task::orderByRaw(
            "CASE WHEN status = 'Pending' THEN 0 ELSE 1 END"
        )
        ->orderBy('due_date')
        ->get();

        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $completedTasks = Task::where('status', 'Completed')->count();

        return view('tasks.index', compact(
            'tasks',
            'totalTasks',
            'pendingTasks',
            'completedTasks'
        ));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Completed',
            'due_date' => 'required|date',
        ]);

        Task::create($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task added successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Completed',
            'due_date' => 'required|date',
        ]);

        $task->update($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
```

### 4. Database Migration

The migration creates the `tasks` table.

Location:

```text
database/migrations/
```

Code:

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('task_name');
    $table->text('description')->nullable();
    $table->enum('status', ['Pending', 'Completed'])
          ->default('Pending');
    $table->date('due_date');
    $table->timestamps();
});
```

The table stores the task name, description, status, due date, and timestamps.

### 5. Blade View

The main task page is located in:

```text
resources/views/tasks/index.blade.php
```

Example of displaying the tasks:

```php
@foreach($tasks as $task)
    {{ $task->task_name }}
@endforeach
```

Blade is used to display the task information on the website.

## CRUD Operations

The system uses CRUD operations:

| CRUD   | System Function           |
| ------ | ------------------------- |
| Create | Add Task                  |
| Read   | View Tasks                |
| Update | Edit Task / Update Status |
| Delete | Delete Task               |

## Database

The system uses **MySQL**.

Database name:

```text
task_manager
```

Main table:

```text
tasks
```

The `tasks` table contains:

```text
id
task_name
description
status
due_date
created_at
updated_at
```

## System Screenshots

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Add New Task

![Add New Task](screenshots/add-task.png)

### Task List

![Task List](screenshots/task-list.png)

### Edit Task

![Edit Task](screenshots/edit-task.png)

### Completed Task

![Completed Task](screenshots/completed-task.png)

### Delete Task

![Delete Task](screenshots/delete-task.png)

## System Outputs

### Adding a Task

After the user submits the Add New Task form, the new task appears in the task list.

### Viewing Tasks

The task list displays the saved tasks together with their description, status, and due date.

### Editing a Task

After editing a task, the updated information appears in the task list.

### Updating Task Status

The task status can be changed from **Pending** to **Completed**.

### Deleting a Task

After deleting a task, the selected task is removed from the task list.

### Dashboard Counters

The dashboard displays the total number of tasks and the number of pending and completed tasks.

## Project Structure

```text
Personal-Task-Manager-Laravel/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── TaskController.php
│   │
│   └── Models/
│       └── Task.php
│
├── database/
│   └── migrations/
│       └── create_tasks_table.php
│
├── resources/
│   └── views/
│       └── tasks/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
│
├── routes/
│   └── web.php
│
├── composer.json
├── Dockerfile
└── README.md
```

## How to Run the Project

### 1. Start MySQL

Make sure the **MySQL267** service is running.

### 2. Open Command Prompt

Go to the project folder:

```cmd
cd /d "C:\Users\kings\OneDrive\Desktop\Personal-Task-Manager-Laravel"
```

### 3. Start Laravel

Run:

```cmd
set PATH=C:\xampp\php;%PATH% && php artisan serve
```

### 4. Open the Website

Open a browser and go to:

```text
http://127.0.0.1:8000/tasks
```

### 5. Use the System

The user can add, view, edit, update the status, and delete tasks.

## Laravel Flow

```text
Routes
   ↓
Controller
   ↓
Model
   ↓
MySQL Database
   ↓
Blade
```

* **Routes** handle the URLs and requests.
* **Controller** handles the system logic.
* **Model** communicates with the database.
* **MySQL** stores the task information.
* **Blade** displays the system interface.

## Notes for Submission

The `vendor` folder and `.env` file are not included in the repository.

The `vendor` folder is generated by Composer, while the `.env` file contains local application and database settings.
