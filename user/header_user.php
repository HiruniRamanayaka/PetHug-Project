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
    <link rel="stylesheet" href="../afterLoginUser_style/header.css" type="text/css">
    <?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';?>
</head>
<body>
    
    <!--header section-->
    <header class="header">
        <div id="logo">
            <img src="../images/PetHugLogo.png">
        </div>
        <nav class="nav-bar">
            <!-- Hamburger icon -->
            <div class="hamburger" onclick="toggleMenu()">&#9776;</div>

            <ul class="nav-links">
                <li><a href="home.php" class="<?php if ($current_page == 'home.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="dashboard.php" class="<?php if($current_page == 'dashboard.php'){echo 'active';} ?>">Dashboard</a></li>
                <li><a href="viewPets.php" class="<?php if($current_page == 'viewPets.php'){echo 'active';} ?>">View <br>Pets</a></li>
                <li><a href="add_pets.php" class="<?php if($current_page == 'add_pets.php'){echo 'active';} ?>">Add <br>Pet</a></li>
                <li><a href="makeAppointment.php" class="<?php if($current_page == 'makeAppointment.php'){echo 'active';} ?>">Make <br>Appointment</a></li> 
                <li><a href="consultation_form.php" class="<?php if($current_page == 'consultation_form.php'){echo 'active';} ?>">Schedule <br>Consultations</a></li>
                <li><a href="request_hostel.php" class="<?php if($current_page == 'request_hostel.php'){echo 'active';} ?>">Request <br>Hostel</a></li>
                <li><a href="medical_records.php" class="<?php if($current_page == 'medical_records.php'){echo 'active';} ?>">Medical <br>Records</a></li>
                <li><a href="bill.php" class="<?php if($current_page == 'bill.php'){echo 'active';} ?>">View <br>Billing</a></li>
                <li><a href="pending_payments.php" class="<?php if($current_page == 'pending_payments.php'){echo 'active';} ?>">Pending <br> Payments</a></li>

                <li><button><a href="user_notifications.php"><i style="font-size: 30px" class="fas fa-bell"></i></a></button></li>
                
                <li>
                    <button onclick="togglePopup('profilePopup')"><i style="font-size: 30px" class="fas fa-user-circle"></i></button>
                    <div id="profilePopup" class="popup">
                        <p><a href="userProfile.php">Profile</a></p><br>
                        <p><a href="my_appointments.php">My Appointments</a></p><br>
                        <p><a href="my_consultations.php">My Consultations</a></p><br>
                        <p><a href="my_hostel.php">My Hostels</a></p><br>
                        <p><a href="payment_history.php">Payment History</a></p><br>
                        <p><a href="../logout.php">Logout</a></p>
                    </div>
                </li>

                

            </ul>
        </nav>
    </header>
    <script src="../javascript_A/header.js"></script>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');  // Toggle the 'active' class to show or hide the menu
        }
    </script>
</body>
</html>