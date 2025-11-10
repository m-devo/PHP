<?php
session_start();

require_once __DIR__ . "/../models/userProfile.php";       
require_once __DIR__ . "/../services/manageUsers.php";   

$userData = null; 
$pageTitle = ""; 

if (isset($_GET['index'])) {
    
    $pageTitle = "View User Profile";
    $filename = __DIR__ . "/../data/users.json"; 
    $boardManager = new UserBoardManager($filename);
    
    $userIndex = (int)$_GET["index"];
    $userData = $boardManager->getUserByIndex($userIndex);

    if (!$userData) {
        echo "User not found.";
        exit;
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $pageTitle = "Thank You for Registering";
    require_once __DIR__ . "/../validators/registerationValidator.php"; 

    $validator = new RegisterationValidator($_POST, $_FILES);

    if (!$validator->formValidation()) {
        $_SESSION['errors'] = $validator->getErrors();
        $_SESSION['savedData'] = $_POST;
        header('Location: /../registeration.php');
        exit;
    }

    $validatedData = $validator->getValidatedData();

    if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $validator->targetFile)) {
         $errors[] = "An error has occured during the upload of pic";
         $_SESSION['errors'] = $errors;
         $_SESSION['savedData'] = $validatedData;
         header('Location: ../registeration.php');
         exit();
    }

    $user = new UserProfile($validatedData);
    $user->setProfilePicPath($validator->displayPath); 

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

    $filename = __DIR__ . "/../data/users.json"; 
    try {
        $boardManager = new UserBoardManager($filename);
        $boardManager->addUser($userData);

    } catch (Exception $e) {
        $errors[] = "An error has occured while saving the data. Please try again later.";
        $_SESSION["errors"] = $errors;
        $_SESSION["savedData"] = $_POST; 
        header("Location: ../registeration.php");
        exit();
    }

    unset($_SESSION['savedData']);

} else {
    header("Location: /public/details.php");
    exit;
}

$title = (strtolower($userData['sex']) === 'male') ? 'Mr' : 'Miss';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
</head>

<body class="bg-gray-100">
<?php include "navbar.php"; ?>
<main class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 sm:p-8">
        
        <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden border-2 border-indigo-600">
            <img src="<?php echo htmlspecialchars($userData['profilePath']); ?>" alt="Profile Picture" class="w-full h-full object-cover">
        </div>

        <h3 class="text-2xl font-bold text-center">
            <?php echo htmlspecialchars($pageTitle); ?>
        </h3>
        <h4 class="text-xl font-medium text-center mb-5">
            (<?php echo $title; ?>) <?php echo htmlspecialchars($userData['firstName']); ?> <?php echo htmlspecialchars($userData['lastName']); ?>
        </h4>
        
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <p class="text-red-800 mb-5 text-center">Please Review Your Information:</p>
        <?php endif; ?>

        <div class="space-y-4">
            
            <div>
                <h1 class="block text-sm font-medium">Name:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['firstName']); ?> <?php echo htmlspecialchars($userData['lastName']); ?></h1>
            </div>

            <div>
                <h1 class="block text-sm font-medium">Address:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['address']); ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Email:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['email']); ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Country:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['country']); ?></h1>
            </div>
            
            <div>
                <h1 class="block text-sm font-medium">Skills:</h1>
                <div class="flex flex-wrap gap-2 mt-2">
                    <?php
                    // [معدل]: بنقرا من الـ array
                    $userSkills = $userData['skills'] ?? []; // <-- بنستخدم $userData
                    if (!empty($userSkills)) {
                        foreach ($userSkills as $skill) {
                            echo "<h1 class='bg-gray-200 px-2 py-1 rounded-full text-sm'>" . htmlspecialchars($skill) . "</h1>";
                        }
                    } else {
                        echo "<h1>No skills selected.</h1>";
                    }
                    ?>
                </div>
            </div>

            <div>
                <h1 class="block text-sm">Department:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['department']); ?></h1>
            </div>

            <div>
                <h1 class="block text-sm">Sex:</h1>
                <h1 class="text-lg font-medium"><?php echo htmlspecialchars($userData['sex']); ?></h1>
            </div>
            
            <div class="pt-4">
                <a href="details.php" class="text-indigo-600 hover:underline">
                    &larr; Back to All users
                </a>
            </div>

        </div>

    </div>
    </main>
</body>
</html>