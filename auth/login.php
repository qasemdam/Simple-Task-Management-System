<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/User.php";

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$message = "";

if (isset($_SESSION["id"])) {

    if ($_SESSION["is_admin"] == 1) {

        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/dashboard.php");
    }
    exit();

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please fill all fields.";

    } else {

        $foundUser = $user->findByEmail($email);

        if ($foundUser && password_verify($password, $foundUser["password"])) {

            $_SESSION["id"] = $foundUser["id"];
            $_SESSION["first_name"] = $foundUser["first_name"];
            $_SESSION["is_admin"] = $foundUser["is_admin"];

            if ($foundUser["is_admin"] == 1) {

                header("Location: ../admin/dashboard.php");

            } else {

                header("Location: ../user/dashboard.php");

            }

            exit();

        } else {

            $message = "Invalid Email or Password.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Management System | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../assets/style.css">

</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card login-card p-4" style="width:420px;">

        <div class="login-logo text-center mb-4">

            <i class="fas fa-tasks text-primary"></i>

            <h2 class="text-primary mt-3">TaskManager</h2>

            <p class="text-muted">
                Simple Task Management System
            </p>

        </div>

        <!-- Success Message -->

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

        <!-- Error Message -->

        <?php if(!empty($message)): ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">

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

                <label class="form-label">Email</label>

                <div class="input-group">

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter Email"
                        required>

                    <span class="input-group-text">

                        <i class="fas fa-envelope"></i>

                    </span>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <div class="input-group">

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter Password"
                        required>

                    <span class="input-group-text">

                        <i class="fas fa-lock"></i>

                    </span>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-primary w-100">

                <i class="fas fa-sign-in-alt"></i>

                Login

            </button>

        </form>

        <hr>

        <div class="text-center">

            <a href="register.php" class="text-decoration-none">

                Create New Account

            </a>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>