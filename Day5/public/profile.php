<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /public/login.php");
    exit;
}

require_once __DIR__ . '/../services/displyUserProfile.php'; 

$currentUsername = $_SESSION["username"];
$filename = __DIR__ . "/../data/users.json"; 

$userProfile = new DisplyUserProfile($filename);
$userData = $userProfile->fetchUserData($currentUsername);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>My Profile</title>
  </head>
  <body>
    
<?php include "navbar.php"; ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">My Profile</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    
    <?php if ($userData):?>
        <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden border-2 border-indigo-600">
            <img src="<?php echo $userData['profilePath']; ?>" alt="Profile Picture" class="w-full h-full object-cover">
        </div>

        <div class="space-y-4">
            <div>
                <h3 class="block text-sm font-medium text-gray-500">Full Name</h3>
                <p class="text-lg font-medium"><?php echo $userData['firstName']; ?> <?php echo $userData['lastName']; ?></p>
            </div>
            
            <div>
                <h3 class="block text-sm font-medium text-gray-500">Username</h3>
                <p class="text-lg font-medium"><?php echo $userData['username']; ?></p>
            </div>

            <div>
                <h3 class="block text-sm font-medium text-gray-500">Email</h3>
                <p class="text-lg font-medium"><?php echo $userData['email']; ?></p>
            </div>
            
            <div>
                <h3 class="block text-sm font-medium text-gray-500">Address</h3>
                <p class="text-lg font-medium"><?php echo $userData['address']; ?></p>
            </div>
            
            <div>
                <h3 class="block text-sm font-medium text-gray-500">Department</h3>
                <p class="text-lg font-medium"><?php echo $userData['department']; ?></p>
            </div>
        </div>

    <?php else: ?>
        <p class="text-red-500 text-center">Could not find this profile data.</p>
    <?php endif; ?>
  </div>
</div>
  </body>
</html>