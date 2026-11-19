# Student Management System

A simple PHP and MariaDB/MySQL CRUD application for registering, viewing, editing, and deleting student records. It is designed for local development with XAMPP.

## Features

- Register a student with full name, email, age, and course
- View all registered students
- Edit existing student information
- Delete a student record with a confirmation prompt
- Validate required fields, email addresses, and ages
- Use PDO prepared statements for database operations
- Responsive layout for desktop and mobile screens

## Technology stack

- PHP 8.0 or later (PHP 7.4 may work)
- MariaDB or MySQL
- HTML5 and CSS3
- PDO MySQL driver
- XAMPP for a convenient local Apache/PHP/MariaDB environment

## Project structure

```text
School-Management/
├── assets/
│   └── css/
│       └── style.css
├── config/
│   └── db.php
├── database/
│   └── schema.sql
├── create.php
├── delete.php
├── edit.php
├── index.php
├── .gitignore
└── README.md
```

## Requirements

1. Install XAMPP (or another PHP + Apache + MariaDB/MySQL environment).
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Make sure PHP's `pdo_mysql` extension is enabled.

## Installation

### 1. Download the project

Clone the repository into your XAMPP `htdocs` directory:

```bash
cd C:/xampp/htdocs
git clone https://github.com/Prince-TY/School-Management.git
```

Or download the ZIP from GitHub and extract the project folder into `C:/xampp/htdocs/`.

### 2. Create the database

Open phpMyAdmin at [http://localhost/phpmyadmin](http://localhost/phpmyadmin), select the SQL tab, and run the contents of `database/schema.sql`.

The script creates a database named `school_db` and a `students` table.

### 3. Configure the database connection

Open `config/db.php`. The default configuration is intended for a standard local XAMPP installation:

- Host: `localhost`
- Database: `school_db`
- Username: `root`
- Password: empty

If your local database uses different settings, update the environment variables or the fallback values in `config/db.php`. Do not commit real production passwords or private credentials.

### 4. Run the application

Visit:

```text
http://localhost/School-Management/
```

Use **Register New Student** to add a record. From the students table, use **Edit** or **Delete** to manage records.

## Database schema

The database contains one table:

| Column | Type | Description |
|---|---|---|
| id | INT, primary key, auto increment | Unique student identifier |
| full_name | VARCHAR(150) | Student's full name |
| email | VARCHAR(254) | Student's email address |
| age | INT | Student's age |
| course | VARCHAR(150) | Student's course |

## Main files

- `index.php` — lists students and provides links to create, edit, and delete records
- `create.php` — validates and inserts a new student
- `edit.php` — loads and updates an existing student
- `delete.php` — processes student deletion using a POST request
- `config/db.php` — creates the PDO database connection
- `database/schema.sql` — creates the database and students table
- `assets/css/style.css` — application styling

## Security notes

- Database queries use PDO prepared statements.
- Values displayed in HTML are escaped with `htmlspecialchars()`.
- Deletion is performed through POST rather than a GET link.
- This is a learning project. Before deploying it publicly, add authentication and authorization, CSRF protection, stronger server-side validation, secure production database credentials, and appropriate error logging. Do not expose a development database account to the public internet.

## Current scope

This project currently manages student records only. It does not include user login, roles, attendance, grades, or reporting modules.

## License

No license has been specified yet. All rights remain with the repository owner unless a license is added.
