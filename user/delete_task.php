<?php

session_start();

require_once "../config/Database.php";
require_once "../classes/Task.php";

if (!isset($_SESSION["id"])) {

    header("Location: ../auth/login.php");
    exit();

}

if (!isset($_GET["id"])) {

    header("Location: dashboard.php");
    exit();

}

$db = new Database();
$conn = $db->connect();

$task = new Task($conn);

$task->id = $_GET["id"];

if ($task->delete()) {

    $_SESSION["success"] = "Task Deleted Successfully.";

} else {

    $_SESSION["error"] = "Delete Failed.";

}

header("Location: dashboard.php");
exit();

?>