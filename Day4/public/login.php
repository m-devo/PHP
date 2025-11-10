<?php
session_start();
if (isset($_SESSION["username"])) {
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
    <title>Login</title>
</head>
<body class="bg-gray-100">

<?php include "navbar.php"; ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login to your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        
        <?php
        if (isset($_GET["error"])) {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
            echo '<strong>Error:</strong> Invalid username or password.';
            echo '</div>';
        }
        ?>

        <form action="../controllers/loginController.php" method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                <div class="mt-2">
                    <input id="username" type="text" name="username" required 
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                <div class="mt-2">
                    <input id="password" type="password" name="password" required 
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 
                        text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>