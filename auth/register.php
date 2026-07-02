<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/User.php";

$message = "";
$messageType = "";

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user->first_name = trim($_POST["first_name"]);
    $user->last_name  = trim($_POST["last_name"]);
    $user->email      = trim($_POST["email"]);

    if (
        empty($user->first_name) ||
        empty($user->last_name) ||
        empty($user->email) ||
        empty($_POST["password"])
    ) {

        $message = "Please fill all fields.";
        $messageType = "danger";

    } elseif ($user->findByEmail($user->email)) {

        $message = "Email already exists.";
        $messageType = "danger";

    } else {

        $user->password = password_hash(
            $_POST["password"],
            PASSWORD_DEFAULT
        );

        $user->is_admin = 0;

        if ($user->save()) {
            session_unset();
            session_destroy();
            session_start();

            $_SESSION["success"] = "Account created successfully. Please login.";

            header("Location: login.php");
            exit();

        } else {

            $message = "Registration Failed.";
            $messageType = "danger";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Management System | Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../assets/style.css">

</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card login-card p-4" style="width:450px;">

        <div class="login-logo text-center mb-4">

            <i class="fas fa-user-plus text-success"></i>

            <h2 class="text-success mt-3">Create Account</h2>

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

                <label class="form-label">First Name</label>

                <div class="input-group">

                    <input
                        type="text"
                        name="first_name"
                        class="form-control"
                        placeholder="Enter First Name"
                        required>

                    <span class="input-group-text">

                        <i class="fas fa-user"></i>

                    </span>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">Last Name</label>

                <div class="input-group">

                    <input
                        type="text"
                        name="last_name"
                        class="form-control"
                        placeholder="Enter Last Name"
                        required>

                    <span class="input-group-text">

                        <i class="fas fa-user"></i>

                    </span>

                </div>

            </div>

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

            <button type="submit" class="btn btn-success w-100">

                <i class="fas fa-user-plus"></i>

                Register

            </button>

        </form>

        <hr>

        <div class="text-center">

            <a href="login.php" class="text-decoration-none">

                Already have an account? Login

            </a>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>