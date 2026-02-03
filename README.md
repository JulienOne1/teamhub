# TeamHub

An internal web application for managing employees, projects, and tasks. Built with Laravel 12, it provides both a web interface and a REST API for small teams or internal departments.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php)
![SQLite](https://img.shields.io/badge/SQLite-Database-003087?style=for-the-badge&logo=sqlite)
![Pest](https://img.shields.io/badge/Pest-Testing-000000?style=for-the-badge)
![Tests](https://img.shields.io/badge/Tests-21%20passing-brightgreen?style=for-the-badge)

---

## Features

- **User Management** - Manage team members and their roles
- **Project Management** - Full CRUD operations for projects with status tracking
- **Task Management** - Create, assign, and track tasks within projects
- **REST API** - Full RESTful API with token-based authentication (Laravel Sanctum)
- **Web Interface** - Clean dashboard with project and task management
- **API Tests** - Comprehensive test suite with 21 tests and 136 assertions

---

## Tech Stack

| Technology | Purpose |
|---|---|
| Laravel 12 | Web Framework |
| PHP 8.4 | Backend Language |
| SQLite | Database |
| Laravel Sanctum | API Authentication |
| Tailwind CSS | UI Styling |
| Pest | Testing Framework |

---

## Installation

### Requirements

- PHP 8.4+
- Composer
- Node.js & npm (optional, for Vite)

### Setup

1. **Clone repository**
```bash
git clone https://github.com/JulienOne1/teamhub.git
cd teamhub
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Create database**
```bash
touch database/database.sqlite
php artisan migrate --seed
```

5. **Start server**
```bash
php artisan serve
```

The application is now available at `http://127.0.0.1:8000`

### Default Test Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@teamhub.test | password |

---

## Project Structure

```
teamhub/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/                # REST API Controllers
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── ProjectController.php
│   │   │   │   ├── TaskController.php
│   │   │   │   └── UserController.php
│   │   │   └── Web/                # Web Interface Controllers
│   │   │       ├── DashboardController.php
│   │   │       ├── ProjectController.php
│   │   │       └── TaskController.php
│   │   └── Resources/              # API Resources
│   │       ├── UserResource.php
│   │       ├── ProjectResource.php
│   │       └── TaskResource.php
│   └── Models/
│       ├── User.php
│       ├── Project.php
│       └── Task.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/views/                # Blade Templates
│   ├── layouts/
│   │   └── app.blade.php
│   ├── dashboard.blade.php
│   ├── projects/
│   └── tasks/
├── routes/
│   ├── web.php                     # Web Routes
│   └── api.php                     # API Routes
└── tests/
    └── Feature/
        └── Api/                    # API Tests
            ├── AuthTest.php
            ├── ProjectTest.php
            ├── TaskTest.php
            └── UserTest.php
```

---

## Web Interface

| Page | URL |
|---|---|
| Dashboard | `/dashboard` |
| Projects | `/projects` |
| Create Project | `/projects/create` |
| Tasks | `/tasks` |
| Create Task | `/tasks/create` |

---

## API Documentation

### Base URL
```
http://127.0.0.1:8000/api
```

### Authentication

All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Register
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Get Current User
```http
GET /api/me
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

### Projects

#### Get All Projects
```http
GET /api/projects
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Create Project
```http
POST /api/projects
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json

{
    "name": "Project Name",
    "description": "Project description",
    "start_date": "2026-01-01",
    "end_date": "2026-06-01",
    "status": "planning",
    "owner_id": 1
}
```

#### Get Single Project
```http
GET /api/projects/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Update Project
```http
PUT /api/projects/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json

{
    "name": "Updated Name",
    "status": "active"
}
```

#### Delete Project
```http
DELETE /api/projects/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Get Project Tasks
```http
GET /api/projects/{id}/tasks
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

### Tasks

#### Get All Tasks
```http
GET /api/tasks
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Create Task
```http
POST /api/tasks
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json

{
    "title": "Task Title",
    "description": "Task description",
    "project_id": 1,
    "assigned_to": 2,
    "created_by": 1,
    "priority": "high",
    "status": "todo",
    "due_date": "2026-03-01"
}
```

#### Get Single Task
```http
GET /api/tasks/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Update Task
```http
PUT /api/tasks/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json

{
    "status": "in_progress",
    "priority": "urgent"
}
```

#### Delete Task
```http
DELETE /api/tasks/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

### Users

#### Get All Users
```http
GET /api/users
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Get Single User
```http
GET /api/users/{id}
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Get User Projects
```http
GET /api/users/{id}/projects
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Get User Tasks
```http
GET /api/users/{id}/tasks
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

### Available Values

#### Project Status
| Value | Description |
|---|---|
| `planning` | Project is in planning phase |
| `active` | Project is currently active |
| `on_hold` | Project is on hold |
| `completed` | Project is completed |
| `cancelled` | Project is cancelled |

#### Task Priority
| Value | Description |
|---|---|
| `low` | Low priority |
| `medium` | Medium priority |
| `high` | High priority |
| `urgent` | Urgent priority |

#### Task Status
| Value | Description |
|---|---|
| `todo` | Task is pending |
| `in_progress` | Task is in progress |
| `review` | Task is in review |
| `done` | Task is completed |

---

## Testing

Run the test suite:
```bash
php artisan test
```

### Test Coverage

| Test File | Tests | Description |
|---|---|---|
| AuthTest | 8 | Registration, login, logout, authentication |
| ProjectTest | 8 | Project CRUD and relationships |
| TaskTest | 8 | Task CRUD and status updates |
| UserTest | 5 | User data, projects and tasks |
| **Total** | **21** | **136 assertions** |

---

## License

This project is open source and available under the [MIT License](LICENSE).