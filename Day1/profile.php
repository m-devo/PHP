<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$address = $_POST['address'];
$country = $_POST['country'];
$sex = $_POST['sex'];
$department = $_POST['department'];

if (isset($_POST['skills'])) {
    $skills = $_POST['skills'];
} else {
    $skills = [];
}

$title = "";
if ($sex == "male") {
    $title = "Mr.";
} else if ($sex == "female") {
    $title = "Miss";
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Profile</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 sm:p-8">
        
        <h3 class="text-2xl font-bold">
            Thanks (<?php echo $title; ?>) <?php echo $firstName; ?> <?php echo $lastName; ?>
        </h3>

        <p class="text-red-800 mb-5">Please Review Your Information:</p>
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
                <h1 class="block text-sm font-medium">Address:</h1>
                <h1 class="text-lg font-medium"><?php echo $country; ?></h1>
            </div>
            
            <div>
                <h1 class="block text-sm font-medium">Skills:</h1>
                <div class="flex flex-wrap gap-2 mt-2">
                    <?php
                    if (!empty($skills)) {
                        
                        foreach ($skills as $skill) {
                            echo "<h1>{$skill}</h1>";
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

        </div>

    </div>

</body>
</html>

