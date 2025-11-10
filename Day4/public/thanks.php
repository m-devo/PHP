<?php
session_start();

require_once __DIR__ . '/../models/userProfile.php';
require_once __DIR__ . '/../validators/registerationValidator.php';

$validator = new RegisterationValidator($_POST, $_FILES);

$successValidation = $validator->formValidation();

if(!$successValidation) {
    $_SESSION['errors'] = $validator->getErrors();
    $_SESSION['savedData'] = $savedData->getValidatedData(); 
    header('Location: ../registeration.php'); 
    exit(); 
}

$targetFile = $validator->targetFile;
$displayPath = $validator->displayPath;

if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {

    $errors[] = "An error has occured during the upload of pic";
    $_SESSION['errors'] = $errors;
    $_SESSION['savedData'] = $validator->getValidatedData();
    header('Location: ../registeration.php');
    exit();
}
$savedData = $validator->getValidatedData();

$user = new UserProfile($savedData);

$user->setProfilePicPath($displayPath);

require_once __DIR__ . '/../storage/storageManager.php';

unset($_SESSION['savedData']);
// profile_pic_path
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Thank You</title>
</head>

<body class="bg-gray-100">
<?php include "navbar.php"; ?>
<main class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 sm:p-8">
        
        <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden border-2 border-indigo-600">
            <img src="<?php echo $user->getProfilePicPath(); ?>" alt="Profile Picture" class="w-full h-full object-cover">
        </div>

        <h3 class="text-2xl font-bold text-center">
            Thanks (<?php echo $user->getTitle(); ?>) <?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?>
        </h3>

        <p class="text-red-800 mb-5 text-center">Please Review Your Information:</p>
        <div class="space-y-4">
            
            <div>
                <h1 class="block text-sm font-medium">Name:</h1>
                <h1 class="text-lg font-medium"><?php echo  $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></h1>
            </div>

            <div>
                <h1 class="block text-sm font-medium">Address:</h1>
                <h1 class="text-lg font-medium"><?php echo $user->getAddress(); ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Email:</h1>
                <h1 class="text-lg font-medium"><?php echo $user->getEmail(); ?></h1>    
            </div>

            <div>
                <h1 class="block text-sm font-medium">Country:</h1>
                <h1 class="text-lg font-medium"><?php echo $user->getCountry(); ?></h1>
            </div>
            
            <div>
                <h1 class="block text-sm font-medium">Skills:</h1>
                <div class="flex flex-wrap gap-2 mt-2">
                    <?php
                    $userSkills = $user->getSkills();
                    if (!empty($userSkills)) {
                        foreach ($userSkills as $skill) {
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
                <h1 class="text-lg font-medium"><?php echo $user->getDepartment(); ?></h1>
            </div>

            <div>
                <h1 class="block text-sm">Sex:</h1>
                <h1 class="text-lg font-medium"><?php echo $user->getSex(); ?></h1>
            </div>
            
            <div class="pt-4">
                <a href="details.php" class="text-indigo-600 hover:underline">
                    &rarr; View All users
                </a>
            </div>

        </div>

    </div>
    </main>
</body>
</html>