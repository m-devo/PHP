<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /public/login.php");
    exit;
}

require_once __DIR__ . '/../services/manageUsers.php'; 
$filename = __DIR__ . "/../data/users.json"; 
$boardManager = new UserBoardManager($filename);

$user = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $indexToUpdate = (int)$_POST['index'];
    
    $oldUser = $boardManager->getUserByIndex($indexToUpdate);
    if (!$oldUser) {
        $error = "Error: User not found. Cannot update.";
    }

    $newPasswordInput = $_POST['password'];
    $passwordToSave = '';

    if (empty($newPasswordInput)) {
        $passwordToSave = $oldUser['password'];
    } else {
        $passwordToSave = password_hash($newPasswordInput, PASSWORD_DEFAULT);
    }
    
    $newData = [
        "firstName" => $_POST['firstName'],
        "lastName" => $_POST['lastName'],
        "email" => $_POST['email'],
        "sex" => $_POST['sex'],
        "country" => $_POST['country'],
        "username" => $_POST['username'],
        "password" => $passwordToSave, 
        "address" => $_POST['address'],
        "department" => $_POST['department'],
        "skills" => $_POST['skills'],
        "profilePath" => $oldUser['profilePath']
        
    ];

    if (empty($error) && $boardManager->updateUser($indexToUpdate, $newData)) {
        header("Location: details.php?status=updated"); 
        exit;
    } else if (empty($error)) {
        $error = "Failed to update user.";
    }
}

if (isset($_GET['index'])) {
    $indexToGet = (int)$_GET["index"];
    $user = $boardManager->getUserByIndex($indexToGet);
    
    if ($user === null) {
        header("Location: details.php");
        exit;
    }
} else {
    header("Location: details.php");
    exit;
}

$skills = $user['skills'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Customer</title>
</head>
<body class="bg-gray-100">
<?php include "navbar.php"; ?>

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 mt-10">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">Edit Customer: <?php echo htmlspecialchars($user['username']); ?></h2>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inindex"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="edit.php" method="POST">
            <input type="hidden" name="index" value="<?php echo htmlspecialchars($user['index']); ?>">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep old password"
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <input type="text" name="department" value="<?php echo htmlspecialchars($user['department']); ?>" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sex</label>
                    <select name="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="Male" <?php if(isset($user['sex']) && $user['sex'] == 'Male') 
                            echo 'selected'; ?>>Male</option>
                        <option value="Female" 
                        <?php if(isset($user['sex']) && $user['sex'] == 'Female') 
                            echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Skills</label>
                    <div class="mt-2 space-y-2">
                        <label><input type="checkbox" name="skills[]" value="PHP" 
                        <?php if(in_array('PHP', $skills)) echo 'checked'; ?>> PHP</label><br>
                        <label><input type="checkbox" name="skills[]" value="JS" 
                        <?php if(in_array('JS', $skills)) echo 'checked'; ?>> JavaScript</label><br>
                        <label><input type="checkbox" name="skills[]" value="MySQL" 
                        <?php if(in_array('MySQL', $skills)) echo 'checked'; ?>> MySQL</label><br>
                        <label><input type="checkbox" name="skills[]" value="Laravel" 
                        <?php if(in_array('Laravel', $skills)) echo 'checked'; ?>> Laravel</label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="inindex-flex justify-center 
                py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md 
                text-white bg-indigo-600 hover:bg-indigo-700">
                    Save Changes
                </button>
                <a href="details.php" class="ml-4 text-gray-600">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>