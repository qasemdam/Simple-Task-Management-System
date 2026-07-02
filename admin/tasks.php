<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/Task.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION["is_admin"] != 1) {
    header("Location: ../user/dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$task = new Task($conn);

// Delete Task
if (isset($_GET["delete"])) {

    $task->id = $_GET["delete"];

    $task->delete();
    $_SESSION["success"] = "Task Deleted Successfully.";
    
    header("Location: tasks.php");
    exit();

}

$tasks = $task->getAllTasks();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Tasks</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container mt-5">
<div class="d-flex justify-content-between align-items-center mb-4">
<h2>Manage Tasks</h2>
<a href="dashboard.php" class="btn btn-secondary">
<i class="fas fa-arrow-left"></i>
Back
</a>
</div>
<table class="table table-bordered table-hover shadow">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>User</th>
<th>Title</th>
<th>Status</th>
<th>Created</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if(count($tasks) > 0): ?>
<?php foreach($tasks as $t): ?>
<tr>
<td><?= $t["id"] ?></td>
<td><?= htmlspecialchars($t["first_name"]) ?> <?= htmlspecialchars($t["last_name"]) ?></td>
<td><?= htmlspecialchars($t["title"]) ?></td>
<td>
<?php if($t["status"] == "Pending"): ?>
<span class="badge bg-warning text-dark">
Pending
</span>
<?php else: ?>
<span class="badge bg-success">
Completed
</span>
<?php endif; ?>
</td>
<td><?= $t["created_at"] ?></td>
<td>
<a
href="../user/edit_task.php?id=<?= $t["id"] ?>"
class="btn btn-primary btn-sm">
<i class="fas fa-edit"></i>
</a>
<a
href="tasks.php?delete=<?= $t["id"] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this task?')">
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