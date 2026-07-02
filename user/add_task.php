<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/Task.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$task = new Task($conn);

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $task->user_id = $_SESSION["id"];
    $task->title = trim($_POST["title"]);
    $task->description = trim($_POST["description"]);
    $task->status = "Pending";

    if (empty($task->title) || empty($task->description)) {

        $message = "Please fill all fields.";
        $messageType = "danger";

    } elseif ($task->save()) {

        $_SESSION["success"] = "Task Added Successfully.";

        header("Location: dashboard.php");
        exit();

    } else {

        $message = "Failed To Add Task.";
        $messageType = "danger";

    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card login-card p-4" style="width:500px;">
        <div class="login-logo text-center mb-4">
            <i class="fas fa-plus-circle text-success"></i>
            <h2 class="text-success mt-3">Add New Task</h2>
            <p class="text-muted">
                Task Management System
            </p>
        </div>
        <?php if(!empty($message)): ?>
            <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Task Title</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Enter Task Title"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                    placeholder="Enter Task Description"
                    required></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a
                    href="dashboard.php"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <button
                    type="submit"
                    class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Add Task
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>