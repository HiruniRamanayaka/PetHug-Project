<?php
    session_start();
    // Get the current page's file name
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="beforeLogin_style/header.css" type="text/css">
</head>
<body>
    
    <!--header section-->
    <header class="header">
        <div id="logo">
            <img src="images/PetHugLogo.png">
        </div>
        
        <nav class="nav-bar">
            <!-- Hamburger icon -->
            <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
            <ul class="nav-links">
                <li><a href="home.php" class="<?php if ($current_page == 'home.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="about.php" class="<?php if($current_page == 'about.php'){echo 'active';} ?>">About Us</a></li>
                <li><a href="services.php" class="<?php if($current_page == 'services.php'){echo 'active';} ?>">Services</a></li>
                <li><a href="contact.php" class="<?php if($current_page == 'contact.php'){echo 'active';} ?>">Contact</a></li>
                <li><a id="login-btn" href="loginAs.php">Log In</a></li>
                <li><a id="signup-btn" href="signupAs.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');  // Toggle the 'active' class to show or hide the menu
        }
    </script>

</body>
</html>