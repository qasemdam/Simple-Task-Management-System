<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/User.php";

if (!isset($_SESSION["id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$message = "";
$messageType = "";

$data = $user->getById($_SESSION["id"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user->id = $_SESSION["id"];
    $user->first_name = trim($_POST["first_name"]);
    $user->last_name = trim($_POST["last_name"]);
    $user->email = trim($_POST["email"]);
if ($user->updateProfile()) {

    $_SESSION["first_name"] = $user->first_name;

    $_SESSION["success"] = "Profile Updated Successfully.";

    header("Location: dashboard.php");
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
<title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
<div class="card login-card p-4" style="width:500px;">
<div class="login-logo text-center mb-4">
<i class="fas fa-user-circle fa-4x text-primary"></i>
<h2 class="mt-3">My Profile</h2>
</div>
<?php if(!empty($message)): ?>
<div class="alert alert-<?= $messageType ?>">
<?= $message ?>
</div>
<?php endif; ?>
<form method="POST">
<div class="mb-3">
<label>First Name</label>
<input
type="text"
name="first_name"
class="form-control"
value="<?= htmlspecialchars($data["first_name"]) ?>"
required>
</div>
<div class="mb-3">
<label>Lst Name</label>
<input
type="text"
name="last_name"
class="form-control"
value="<?= htmlspecialchars($data["last_name"]) ?>"
required>
</div>
<div class="mb-3">
<label>Email</label>
<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($data["email"]) ?>"
required>
</div>
<div class="d-flex justify-content-between">
<a href="dashboard.php" class="btn btn-secondary">
Back
</a>
<button type="submit" class="btn btn-primary">
Update Profile
</button>
</div>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>