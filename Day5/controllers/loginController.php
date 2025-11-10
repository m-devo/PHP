<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /../public/login.php");
    exit;
}

require_once __DIR__ . '/../services/checkLogin.php'; 

$username = trim($_POST["username"]);
$password = $_POST["password"];
$filename = __DIR__ . "/../data/users.json";

$auth = new LoginManager($filename);

if ($auth->authentication($username, $password)) {

    $_SESSION["username"] = $username;
    $_SESSION["profileImagePath"] = $auth->getPicPath(); 

    header("Location: /../public/details.php");
    exit;
    
} else {
    header("Location: /../public/login.php?error=1");
    exit;
}