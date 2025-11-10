<?php
session_start();

$errors = [];
$savedData = $_POST; 

$data = array("firstName","lastName","email","address","country", "sex","username", "password", "confirm_password", "department");
foreach ($data as $requiredData){
    if(empty($_POST[$requiredData])) {
    $errors[] = "This '" . $requiredData . "' is required"; 
    }
}

$pattern = "/^[a-zA-Z]+$/";
$options = [ 'options' => [ 'regexp' => $pattern ] ];
if (!empty($_POST["firstName"]) && filter_var($_POST["firstName"], FILTER_VALIDATE_REGEXP, $options) === false) {
    $errors[] = "First Name must be alphabets only";
}
if (!empty($_POST["lastName"]) && filter_var($_POST["lastName"], FILTER_VALIDATE_REGEXP, $options) === false) {
    $errors[] = "Second Name must be alphabets only";
}

if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "This email format is not valid";
}

if(!empty($_POST["username"]) && preg_match("/\s/",$_POST["username"] )) {
    $errors[] = "User name shouldn't have any spaces";
};

if (!empty($_POST["password"]) && $_POST["password"] !== $_POST["confirm_password"]) {
    $errors[] = "Passwords do not match";
}
if (!empty($_POST["password"]) && strlen($_POST["password"]) !== 8) {
    $errors[] = "Password must be exactly 8 characters";
}
if (!empty($_POST["password"]) && !preg_match('/^[a-z0-9_]+$/', $_POST["password"])) {
    $errors[] = "Password must be lowercase letters, numbers, or underscore only";
}

$profilePicPath = "";
if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == UPLOAD_ERR_OK) {
    $uploadDir = "pics/";
    
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if($check === false) {
        $errors[] = "File is not an image.";
    } else {
        $extension = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
        $safeName = time() . "_" . uniqid() . "." . $extension;
        $targetFile = $uploadDir . $safeName;
    }
} else {
    $errors[] = "Profile picture is required";
}


if (!empty($errors)) {
    
    $_SESSION['errors'] = $errors;
    $_SESSION['savedData'] = $savedData;
    header("Location: registeration.php");
    exit;
}

if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
    $profilePicPath = $targetFile;
} else {
    $_SESSION["errors"] = ["Sorry, there is an error while uploading the file."];
    $_SESSION['savedData'] = $savedData;
    header("Location: registeration.php");
    exit;
}

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$address = $_POST["address"];
$sex = $_POST["sex"];
$country = $_POST["country"];
$username = $_POST["username"]; 
$password = $_POST["password"]; 
$department = $_POST["department"]; 

if (isset($_POST["skills"])) {
    $skills = $_POST["skills"];
} else {
    $skills = [];
}

$title = "";
if ($sex == "male") $title = "Mr.";
if ($sex == "female") $title = "Miss";

$filename = "users.txt"; 
$customerData = [
    "firstName" => $firstName, "lastName" => $lastName, "email" => $email,
    "sex" => $sex, "country" => $country, "address" => $address,
    "username" => $username, "password" => $password, "department" => $department, 
    "skills" => $skills, "profilePath" => $profilePicPath 
];
$json_line = json_encode($customerData, JSON_UNESCAPED_UNICODE);
file_put_contents($filename, $json_line . PHP_EOL, FILE_APPEND);

unset($_SESSION['savedData']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Profile</title>
</head>
<?php include 'navbar.php' ?>;

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 sm:p-8">
        
        <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden border-2 border-indigo-600">
            <img src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="w-full h-full object-cover">
        </div>

        <h3 class="text-2xl font-bold text-center">
            Thanks (<?php echo $title; ?>) <?php echo $firstName; ?> <?php echo $lastName; ?>
        </h3>

        <p class="text-red-800 mb-5 text-center">Please Review Your Information:</p>
        <div class="space-y-4">
            
            <div>
                <h1 class="block text-sm font-medium">Name:</h1>
                <h1 class="text-lg font-medium"><?php echo $firstName; ?> <?php echo $lastName; ?></h1>
            </div>

            <div>
                <h1 class="block text-sm font-medium">Address:</h1>
                <h1 class="text-lg font-medium"><?php echo $address; ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Email:</h1>
                <h1 class="text-lg font-medium"><?php echo $email; ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Country:</h1>
                <h1 class="text-lg font-medium"><?php echo $country; ?></h1>
            </div>
            
            <div>
                <h1 class="block text-sm font-medium">Skills:</h1>
                <div class="flex flex-wrap gap-2 mt-2">
                    <?php
                    if (!empty($skills)) {
                        foreach ($skills as $skill) {
                            echo "<h1 class='bg-gray-200 px-2 py-1 rounded-full text-sm'>" . $skill . "</h1>";
                        }
                    } else {
                        echo "<h1>No skills selected.</h1>";
                    }
                    ?>
                </div>
            </div>

            <div>
                <h1 class="block text-sm">Department:</h1>
                <h1 class="text-lg font-medium"><?php echo $department; ?></h1>
            </div>

            <div>
                <h1 class="block text-sm">Sex:</h1>
                <h1 class="text-lg font-medium"><?php echo $sex; ?></h1>
            </div>
            
            <div class="pt-4">
                <a href="details.php" class="text-indigo-600 hover:underline">
                    &rarr; View All users
                </a>
            </div>

        </div>

    </div>

</body>
</html>