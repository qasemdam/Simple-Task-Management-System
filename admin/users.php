<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/User.php";

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

$user = new User($conn);

// Delete User
if (isset($_GET["delete"])) {

    $user->id = $_GET["delete"];

    // منع الأدمن من حذف نفسه
    if ($user->id != $_SESSION["id"]) {

        $user->delete();

    }

    header("Location: users.php");
    exit();

}

// Get All Users
$users = $user->getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Users</h2>
        <a href="dashboard.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
    <table class="table table-bordered table-hover shadow">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($users) > 0): ?>
            <?php foreach($users as $u): ?>
                <tr>
                    <td><?= $u["id"] ?></td>
                    <td>
                        <?= htmlspecialchars($u["first_name"]) ?>
                        <?= htmlspecialchars($u["last_name"]) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($u["email"]) ?>
                    </td>
                    <td>
                        <?php if($u["is_admin"] == 1): ?>
                            <span class="badge bg-danger">
                                Admin
                            </span>
                        <?php else: ?>
                            <span class="badge bg-primary">
                                User
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($u["id"] != $_SESSION["id"]): ?>
                            <a
                                href="users.php?delete=<?= $u["id"] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this user?')">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        <?php else: ?>
                            <span class="text-muted">
                                Current User
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">
                    No Users Found
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>