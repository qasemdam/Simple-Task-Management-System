<?php

session_start();

if (!isset($_SESSION["id"])) {

    header("Location: ../auth/login.php");
    exit();

}

if ($_SESSION["is_admin"] != 1) {

    header("Location: ../user/dashboard.php");
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>
            <i class="fas fa-user-shield text-dark"></i>
            Welcome Admin,
            <strong><?= $_SESSION["first_name"] ?></strong>
        </h2>
        <p class="text-muted">
            Manage Users And Tasks
        </p>
        <hr>
        <div class="d-grid gap-3">
            <a href="users.php" class="btn btn-primary">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="tasks.php" class="btn btn-success">
                <i class="fas fa-tasks"></i>
                Manage Tasks
            </a>
            <a href="../auth/logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>