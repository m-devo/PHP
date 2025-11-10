<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $filename = "users.txt";
    if (!file_exists($filename)) {
        
        header("Location: login.php?error=1");
        exit;
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $isLoggedIn = false;

    $userProfilePath = "";

    foreach ($lines as $line) {
        $data = json_decode($line, true);
        
        if (is_array($data) && isset($data["username"]) && isset($data["password"])) {
            if ($data["username"] === $username && $data["password"] === $password) {
                $isLoggedIn = true;

                if (isset($data["profilePath"])) {
                    $userProfilePath = $data["profilePath"];
                }
                
                break;
            }
        }
    }

    if ($isLoggedIn) {
        $_SESSION["username"] = $username;
        $_SESSION["profile_pic_path"] = $userProfilePath;

        header("Location: details.php");

        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}
?>