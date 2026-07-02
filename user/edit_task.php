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

$isAdmin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1;

if (!isset($_GET["id"])) {

    if ($isAdmin) {
        header("Location: ../admin/tasks.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

$data = $task->getTaskById($_GET["id"]);

if (!$data) {
    if ($isAdmin) {
        header("Location: ../admin/tasks.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task->id = $_GET["id"];
    $task->title = trim($_POST["title"]);
    $task->description = trim($_POST["description"]);
    $task->status = $_POST["status"];

    if (empty($task->title) || empty($task->description)) {
        $message = "Please fill all fields.";
        $messageType = "danger";
    } elseif ($task->update()) {
        $_SESSION["success"] = "Task Updated Successfully.";
        if ($isAdmin) {
            header("Location: ../admin/tasks.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $message = "Update Failed.";
        $messageType = "danger";

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Task</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
<div class="card login-card p-4" style="width:500px;">
<div class="login-logo text-center mb-4">
<i class="fas fa-edit text-primary"></i>
<h2 class="text-primary mt-3">Edit Task</h2>
<p class="text-muted">
Update Task
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
value="<?= htmlspecialchars($data["title"]) ?>"
required>
</div>
<div class="mb-3">
<label class="form-label">Description</label>
<textarea
name="description"
class="form-control"
rows="5"
required><?= htmlspecialchars($data["description"]) ?></textarea>
</div>
<div class="mb-3">
<label class="form-label">Status</label>
<select
name="status"
class="form-select">
<option
value="Pending"
<?= $data["status"] == "Pending" ? "selected" : "" ?>>
Pending
</option>
<option
value="Completed"
<?= $data["status"] == "Completed" ? "selected" : "" ?>>
Completed
</option>
</select>
</div>
<div class="d-flex justify-content-between">
<a
href="<?= $isAdmin ? "../admin/tasks.php" : "dashboard.php" ?>"
class="btn btn-secondary">
<i class="fas fa-arrow-left"></i>
Back
</a>
<button
type="submit"
class="btn btn-primary">
<i class="fas fa-save"></i>
Update Task
</button>
</div>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>