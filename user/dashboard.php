<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/Task.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SESSION["is_admin"] == 1) {
    header("Location: ../admin/dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$task = new Task($conn);

$tasks = $task->getTasksByUser($_SESSION["id"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>
                <i class="fas fa-user-circle text-dark"></i>
                Welcome,
                <strong><?= $_SESSION["first_name"] ?></strong>
            </h2>
            <p class="text-muted">
                Manage Your Tasks
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="profile.php" class="btn btn-info">
                <i class="fas fa-user"></i>
                Profile
            </a>
            <a href="add_task.php" class="btn btn-success">
                <i class="fas fa-plus"></i>
                Add Task
            </a>
            <a href="../auth/logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>
    <?php if(isset($_SESSION["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION["success"] ?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>
    <table class="table table-bordered table-hover shadow">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created</th>
                <th width="180">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($tasks) > 0): ?>
            <?php foreach($tasks as $task): ?>
                <tr>
                    <td><?= $task["id"] ?></td>
                    <td><?= htmlspecialchars($task["title"]) ?></td>
                    <td><?= htmlspecialchars($task["description"]) ?></td>
                    <td>
                        <?php if($task["status"] == "Pending"): ?>
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success">
                                Completed
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?= $task["created_at"] ?></td>
                    <td>
                        <a
                            href="edit_task.php?id=<?= $task["id"] ?>"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a
                            href="delete_task.php?id=<?= $task["id"] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this task?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">
                    No Tasks Found
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>