<?php 

$filename = __DIR__ . "/../data/users.json";

$userData = [
    "firstName" => $user->getFirstName(),
    "lastName" => $user->getLastName(),
    "email" => $user->getEmail(),
    "sex" => $user->getSex(),
    "country" => $user->getCountry(),
    "address" => $user->getAddress(),
    "username" => $user->getUsername(),
    "department" => $user->getDepartment(), 
    "password" => $user->getPasswordHash(),
    "skills" => $user->getSkills(), 
    "profilePath" => $user->getProfilePicPath()
];
$json_line = json_encode($userData, JSON_UNESCAPED_UNICODE);
// echo $json_line;
// die();
file_put_contents($filename, $json_line . PHP_EOL);

?>