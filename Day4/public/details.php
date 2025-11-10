<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /public/login.php");
    exit;
}
require_once __DIR__ . '/../services/manageUsers.php'; 

$filename = __DIR__ . "/../data/users.txt"; 
$boardManager = new UserBoardManager($filename);

if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["line"])) { 
    
    $lineToDelete = (int)$_GET["line"];
    
    $boardManager->deleteUser($lineToDelete); 
    
    header("Location: details.php"); 
    exit; 
}

$allUsers = $boardManager->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Customer Details</title>
</head>
<body>
<?php include "navbar.php"; ?>

    <div class="max-w-6xl mx-auto mb-4">
        <strong>Welcome, <?php echo $_SESSION["username"]; ?>!</strong>
        <a href="/../controllers/logoutController.php" class="text-indigo-600" style="margin-left: 15px;">Logout</a>
    </div>

    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">All Customer Records</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Sex</th>
                        <th>Country</th>
                        <th>User Name</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Skills</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        foreach ($allUsers as $user) {
                            
                            $deleteLine = $user["line"] ?? null; 

                            if (!$deleteLine) {
                                continue; 
                            }
                            
                            echo "<tr>";
                            echo "<td>" . $user["firstName"] . "</td>";
                            echo "<td>" . $user["lastName"] . "</td>";
                            echo "<td>" . $user["email"] . "</td>";
                            echo "<td>" . $user["sex"] . "</td>";
                            echo "<td>" . $user["country"] . "</td>";
                            echo "<td>" . $user["username"] . "</td>";
                            echo "<td>" . $user["address"] . "</td>";
                            echo "<td>" . $user["department"] . "</td>";    
                            
                            echo "<td>";
                            if (isset($user["skills"]) && is_array($user["skills"])) {
                                echo implode(", ", $user["skills"]);
                            }
                            echo "</td>";
                            
                            echo "<td>";
                            echo '<a href="details.php?action=delete&line=' . $deleteIndex . '" 
                            class="text-red-600" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <a href="/../registeration.php" class="text-indigo-600">
                &larr; Add New Customer
            </a>
        </div>
    </div>

</body>
</html>