# 📋 Simple Task Management System

A web-based Task Management System developed using **PHP**, **MySQL**, and **Bootstrap** following the **Object-Oriented Programming (OOP)** approach.

The system allows users to manage their personal tasks while providing administrators with full control over users and tasks through a dedicated admin dashboard.

---

## ✨ Features

### 👤 User
- Register a new account
- Secure Login & Logout
- Update Profile Information
- Add New Tasks
- Edit Existing Tasks
- Delete Tasks
- View Personal Task List

### 👑 Admin
- Secure Admin Login
- View All Users
- Delete Users
- View All Tasks
- Edit Any Task
- Delete Any Task

---

## 🛠️ Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- Font Awesome
- PDO (Prepared Statements)
- Object-Oriented Programming (OOP)

---

## 🔒 Security

- Password Hashing using `password_hash()`
- Password Verification using `password_verify()`
- PDO Prepared Statements to prevent SQL Injection
- Session Authentication
- Role-Based Access Control (Admin / User)

---

## 📂 Project Structure

```text
TaskSystem/
│
├── admin/
├── assets/
├── auth/
├── classes/
├── config/
├── user/
├── index.php
└── task_system.sql
```

---

## 🚀 Getting Started

1. Clone this repository.
2. Import `task_system.sql` into phpMyAdmin.
3. Copy the project folder to the `htdocs` directory.
4. Start Apache and MySQL using XAMPP.
5. Open:

```
http://localhost/TaskSystem/
```

6. Login or create a new account.

---

## 📸 Screenshots

> Add screenshots of:
- Login Page
- Register Page
- User Dashboard
- Add Task
- Edit Task
- Profile
- Admin Dashboard
- Manage Users
- Manage Tasks

---

## 👨‍💻 Author

**Qasem Dam**
