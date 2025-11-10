<?php
$data = array("firstName","lastName","email","address","country", "sex","username", "password", "department");

foreach ($data as $requiredData){
    if(empty($_POST[$requiredData])) {
      die("This '" . $requiredData . "' is required"); 
    }
}
$pattern = "/^[a-zA-Z]+$/";

$options = [
	'options' => [
		'regexp' => $pattern
    ]
];

filter_var($firstName, FILTER_VALIDATE_REGEXP, $options);

if (filter_var($_POST["firstName"], FILTER_VALIDATE_REGEXP, $options) === false) {
    die("First Name must be aphabets only");
}

if (filter_var($_POST["lastName"], FILTER_VALIDATE_REGEXP, $options) === false) {
    die("Second Name must be aphabets only");
}

if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
    die("This email format is not valid");
}

if(preg_match("/\s/",$_POST["username"] )) {
    die("User name shouldn't have any spaces");
};


$sanitaizedData = [];
foreach ($data as $requiredData){
    $sanitaizedData[$requiredData] = filter_var($_POST[$requiredData], FILTER_SANITIZE_SPECIAL_CHARS);
}

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$address = $_POST["address"];
$sex = $_POST["sex"];
$country = $_POST["country"];
$sex = $_POST["sex"];
$department = $_POST["department"];

if (isset($_POST["skills"])) {
    $skills = $_POST["skills"];
} else {
    $skills = [];
}

$title = "";
if ($sex == "male") {
    $title = "Mr.";
} else if ($sex == "female") {
    $title = "Miss";
}
// saving registeration data

$filename = "customer.txt";
$customerData = [
    "firstName" => $firstName,
    "lastName" => $lastName,
    "email" => $email,
    "sex" => $sex,
    "country" => $country,
    "address" => $address,
    "department" => $department,
    "skills" => $skills 
];

$json_line = json_encode($customerData, JSON_UNESCAPED_UNICODE);

file_put_contents($filename, $json_line . PHP_EOL, FILE_APPEND);
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

