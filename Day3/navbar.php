<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-red-800 p-4 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white font-bold text-lg">
            <a href="registeration.php">Registeration System :)</a>
        </div>
        <div class="flex space-x-4 items-center">
            
            <a href="registeration.php" class="text-gray-300 hover:text-white">Register</a>
            <a href="details.php" class="text-gray-300 hover:text-white">Users</a>
            
            <?php if (isset($_SESSION["username"])): ?>
                
                <a href="profile.php" class="text-yellow-300 hover:text-white font-bold">My Profile</a>

                <?php 
                if (isset($_SESSION["profile_pic_path"]) && !empty($_SESSION["profile_pic_path"])): 
                ?>
                    <img src="<?php echo $_SESSION['profile_pic_path']; ?>" 
                         alt="Avatar" 
                         class="w-8 h-8 rounded-full object-cover">
                <?php endif; ?>
                <span class="text-blue-300">
                    Welcome, <?php echo $_SESSION["username"]; ?>
                </span>
                <a href="logout.php" class="text-gray-300 hover:text-white bg-red-600 px-3 py-1 rounded">Logout</a>
                
            <?php else: ?>
                <a href="login.php" class="text-gray-300 hover:text-white bg-blue-600 px-3 py-1 rounded">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>