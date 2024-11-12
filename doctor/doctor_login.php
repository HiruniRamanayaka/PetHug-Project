<?php
    session_start();

    include_once "../connection.php";

    if(isset($_POST['login'])){
        $email = $_POST['dr_email'];
        $password = $_POST['dr_password'];

        if(empty($email) || empty($password)){
            $_SESSION['error_message'] = "All fields are required.";
            header("Location: doctor_login.php");
            exit();
        }else{
            $sql = "SELECT * FROM doctor WHERE dr_email=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                $_SESSION['error_message'] = "SQL error.";
                header("Location: doctor_login.php");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result)){
                    $pswcheck = password_verify($password, $row['dr_password']);
                    if(password_verify($password, $row['dr_password'])){
                        $_SESSION['success_message'] = "Password match!";
                    } else {
                        $_SESSION['success_message'] = "Password doesn't match!";
                    }

                    if($pswcheck == true){
                        $_SESSION['dr_id'] = $row['dr_id'];
                        $_SESSION['dr_email'] = $row['dr_email'];

                        $_SESSION['success_message'] = "Login successful!"; // should include in dashboard
                        header("Location: doctor_dashboard.php");
                        exit();
                    }else{
                        $_SESSION['error_message'] = "Incorrect password.";
                        header("Location: doctor_login.php");
                        exit();
                    }
                }else{
                    $_SESSION['error_message'] = "No user found.";
                    header("Location: doctor_login.php");
                    exit();
                }
            }
        }     
    }
$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login form</title>
    <link rel="stylesheet" href="../afterLoginUser_style/login.css">
</head>
<body>

    <?php
        if(isset($_SESSION['error_message'])) {
            echo '<p style="color:red;">'.$_SESSION['error_message'].'</p>';
            unset($_SESSION['error_message']);
        }
    ?>

    <div class="form">
        <h2>Welcome to PetHug! Please Login</h2>

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <input id="email" type="email" name="dr_email" size="35" placeholder="email"><br><br> 
            <input id="password" type="password" name="dr_password" size="35" placeholder="Password" maxlength="15"><br>
            <a href="forgot_password.php">Forgot Password ?</a><br><br>
            <input id="submit" type="submit" name="login" value="Log in">
        </form>
    </div>


</body>
</html>