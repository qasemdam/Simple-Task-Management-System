<?php
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION["is_admin"] == 1) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
} else {
    header("Location: auth/login.php");
}
exit();
?>