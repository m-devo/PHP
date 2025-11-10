<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /../public/login.php");
    exit;
}

require_once __DIR__ . "/../data/database.php"; 

require_once __DIR__ . "/../services/checkLogin.php"; 

$username = trim($_POST["username"]);
$password = $_POST["password"];

$auth = new LoginManager($pdo);

$userData = $auth->authentication($username, $password);

if ($userData) {
    $_SESSION["username"] = $userData["username"];
    $_SESSION["profileImagePath"] = $userData["profilePath"] ?? null;
    $_SESSION["role"] = $userData["role"] ?? "user";

    header("Location: /../public/details.php");
    exit;
    
} else {
    header("Location: /../public/login.php?error=1");
    exit;
}