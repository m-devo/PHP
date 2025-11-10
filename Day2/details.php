<?php
$filename = "customer.txt";
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["line"])) { 
    $lineToDelete = (int)$_GET["line"];
    if (file_exists($filename)) {
        
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (isset($lines[$lineToDelete])) {
            
            unset($lines[$lineToDelete]);
            file_put_contents($filename, implode(PHP_EOL, $lines) . PHP_EOL);
        }
    }
    header("Location: details.php");
    exit; 
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Customer Details</title>
</head>
<body class="bg-gray-100 p-8">

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
                        <th>Address</th>
                        <th>Department</th>
                        <th>Skills</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $filename = "customer.txt";
                        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        
                        foreach ($lines as $index => $line) {
                            $data = json_decode($line, true);                            
                            if (!is_array($data)) {
                                continue;
                            }
                            echo "<tr>";
                            echo "<td>" . $data["firstName"] . "</td>";
                            echo "<td>" . $data["lastName"] . "</td>";
                            echo "<td>" . $data["email"] . "</td>";
                            echo "<td>" . $data["sex"] . "</td>";
                            echo "<td>" . $data["country"] . "</td>";
                            echo "<td>" . $data["address"] . "</td>";
                            echo "<td>" . $data["department"] . "</td>";    
                            echo "<td>";
                            $skills_string = "";
                            $count = 0;
                            foreach ($data["skills"] as $skill) {
                                $skills_string .= $skill;
                                $count++;
                                if ($count < count($data["skills"])) {
                                    $skills_string .= ", ";
                                }
                            }
                            echo $skills_string;
                            echo "</td>";
                            
                            echo "<td>";
                            echo '<a href="details.php?action=delete&line=' . $index . '" 
                            class="text-red-600" onclick="return confirm(\'Are you sure?\');">Delete</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
             <a href="./registeration.php" class="text-indigo-600">
                &larr; Add New Customer
            </a>
        </div>
    </div>

</body>
</html>