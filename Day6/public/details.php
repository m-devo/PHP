<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /public/login.php");
    exit;
}
$isAdmin = (isset($_SESSION["role"]) && $_SESSION["role"] === "admin");

require_once __DIR__ . '/../data/database.php'; 

if (!$pdo instanceof PDO) {
     throw new Exception("Database connection failed.");
}

require_once __DIR__ . '/../storage/userDatabaseManager.php';
$dbManager = new UserDatabaseManager($pdo);

if ($isAdmin && isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) { 
    $idToDelete = (int)$_GET["id"];
    $dbManager->deleteUser($idToDelete); 
    header("Location: details.php"); 
    exit; 
}

if ($isAdmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "changeRole") {  
    $idToUpdate = (int)$_POST["userId"]; 
    $newRole = $_POST["newRole"];
    
    $oldUser = $dbManager->getUserById($idToUpdate); 
    if ($oldUser) {
        $oldUser["role"] = $newRole;
        $dbManager->updateUser($idToUpdate, $oldUser);
    }
    header("Location: details.php"); 
    exit;
}

$allUsers = $dbManager->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>User Details</title>
    <style>
        th, td { padding: 12px 15px; text-align: left; }
    </style>
</head>
<body class="bg-gray-100">
<?php include "navbar.php"; ?>

    <div class="max_w-6xl mx_auto mb-4 mt-6">
        <strong>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</strong>
        <a href="/../controllers/logoutController.php" class="text-indigo-600" style="margin-left: 15px;">Logout</a>
    </div>

    <div class="max_w-6xl mx_auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">All Customer Records</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Sex</th>
                        <th>Country</th>
                        <th>User Name</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Skills</th>
                        <?php if ($isAdmin): ?>
                            <th>View</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Change Role</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        foreach ($allUsers as $user) {
                            
                            $userId = $user["id"]; 
                            $currentRole = $user['role'] ?? 'user';
                            echo "<tr>";
                            echo "<td>" . $userId . "</td>";
                            echo "<td>" . htmlspecialchars($user["firstName"] ) . "</td>";
                            echo "<td>" . htmlspecialchars($user["lastName"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["sex"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["country"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["username"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["address"]) . "</td>";
                            echo "<td>" . htmlspecialchars($user["department"]) . "</td>";    
                            
                            echo "<td>";
                            if (isset($user["skills"]) && is_array($user["skills"])) {
                                echo htmlspecialchars(implode(", ", $user["skills"]));
                            }
                            echo "</td>";
                            
                            if ($isAdmin) {
                                // View
                                echo '<td>';
                                echo '<a href="thanks.php?id=' . $userId . '" 
                                      class="text-green-600">View</a>';
                                echo "</td>";
                                
                                // Update
                                echo '<td>';
                                echo '<a href="edit.php?id=' . $userId . '" 
                                      class="text-blue-600">Update</a>';
                                echo "</td>";
                                
                                // Delete
                                echo '<td>';
                                echo '<a href="details.php?action=delete&id=' . $userId . '" 
                                class="text-red-600" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                                echo "</td>";
                                
                                // Addin chang role  
                                echo '<td>';
                                echo '<form action="details.php" method="POST" class="flex items-center gap-2">';
                                echo '    <input type="hidden" name="action" value="changeRole">'; 
                                echo '    <input type="hidden" name="userId" value="' . $userId . '">';
                                echo '    <select name="newRole" class="block w-full rounded-md border-gray-300 shadow-sm text-sm p-1">';
                                echo '        <option value="user"' . ($currentRole == "user" ? ' selected' : '') . '>User</option>';
                                echo '        <option value="admin"' . ($currentRole == "admin" ? ' selected' : '') . '>Admin</option>';
                                echo '    </select>';
                                echo '    <button type="submit" class="text-sm bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Save</button>';
                                echo '</form>';
                                echo '</td>';
                            }
                            
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <?php if ($isAdmin): ?>
                <a href="/../registeration.php" class="text-indigo-600">
                    &larr; Add New User
                </a>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>