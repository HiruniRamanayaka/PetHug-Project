<?php

    session_start();

        include_once "../connection.php";

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
            header("Location: user_login.php");
            exit();
        }
        
        $user_id = $_SESSION['user_id'];
        $email = $_SESSION['user_email'];
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View pets</title>
    <link rel="stylesheet" href="../afterLoginUser_style/viewPets.css">
</head>
<body>
    <!--header-->
    <?php include_once "header_user.php"?>

    <h1 class="pets">My Pets</h1>

    <!-- Elements to display error and success messages -->
    <?php
            if(isset($_SESSION['error_message3'])) {
                echo '<p style="color:red;">'.$_SESSION['error_message3'].'</p>';
                unset($_SESSION['error_message3']);
            }
            if(isset($_SESSION['success_message3'])) {
                echo '<p style="color:green;">'.$_SESSION['success_message3'].'</p>';
                unset($_SESSION['success_message3']);
            }
    ?>

    <div class="container">
    <!-- Display Pets in Cards -->
    <?php 
        $sql = "SELECT * FROM pet WHERE user_id = $user_id ORDER BY pet_id ASC";
        $result = mysqli_query($conn,$sql);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                echo "<div class='pet-card'>
                        <img src='".$row['pet_image']."'alt='pet-photo'>
                        <h3>".$row['pet_name']."</h3>
                        <p>Species: ".$row['species']."</p>
                        <p>Breed: ".$row['breed']."</p>
                        <p>Age: ".$row['age']." years</p>
                        <p>Gender: ".$row['gender']."</p>
                        <a href='pet.php?pet_id=".$row['pet_id']."' id='pet".$row['pet_id']."'>View Details</a>
                    </div>";
            }
        }else {
            echo "<p>No pets found.</p>";
        }

    ?>  
    </div>            

    <!--footer-->
    <?php include_once "footer_user.php"?>
</body>
</html>

<?php $conn->close(); ?>