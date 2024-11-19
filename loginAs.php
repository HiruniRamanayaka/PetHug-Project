<?php
// Get the current page's file name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        *{
          margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
}

body{
    font-family: 'Arial', sans-serif;
    
}

.header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color:   #6666ff ;
    padding: 5px 5% 5px 0;
    height: 130px;
}

#logo{
    display: flex;
    justify-content: left;
    width: auto;
    max-width: 200px; 
    flex-shrink: 0;
    margin-left: 5%;
}

#logo img{
    width: 100%;
    height: auto;
    object-fit: contain;
}

.nav-links{
    list-style-type: none;
    display: flex;
    gap: 30px;
    padding: 0;
    flex-shrink: 0;
}

.nav-links a{
    text-decoration: none;
    color:white;
    font-weight:700;
}



#signup-btn{
    padding: 10px 20px;
    border: 2px solid    #03045e;
    border-radius: 20px;
}

.nav-links a:hover{
    color:    #03045e;
}

.nav-links a.active {
    color:   #03045e !important; 
    font-weight: 700; 
}


        </style>
</head>
<body>
    
    <!--header section-->
    <header class="header">
        <div id="logo">
            <img src="images/PetHugLogo.png">
        </div>
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="index.php" class="<?php if ($current_page == 'index.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="about.php" class="<?php if($current_page == 'about.php'){echo 'active';} ?>">About Us</a></li>
                <li><a href="services.php" class="<?php if($current_page == 'services.php'){echo 'active';} ?>">Services</a></li>
                <li><a href="contact.php" class="<?php if($current_page == 'contact.php'){echo 'active';} ?>">Contact</a></li>
                
                <li><a id="signup-btn" href="signupAs.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Selection - PetHug</title>
    <link rel="stylesheet" href="css/signupAs.css" type="text/css">
    
</head>
<body>
    <div class="container">
        <h2>Select Sign in Option</h2>
        <p>Please choose how you want to log in:</p>
        <div class="button-group">
            <a href="User/userLogin.php"><button class="btn">Log in as User</button></a>
            <a href="Doctor/doctorLogin.php"><button class="btn">Log in as Doctor</button></a>
            <a href="Admin/adminLogin.php"><button class="btn">Log in as Admin</button></a>
        </div>
    </div>
</body>
</html>

<?php
include_once "footer.php";
?>