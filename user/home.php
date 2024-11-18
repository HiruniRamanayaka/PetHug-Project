<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: userLogin.php");
    exit();
}

include_once "../connection.php";
//header
include_once "header_user.php";

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="../afterLoginUser_style/home.css" type="text/css">
    <?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';?>
</head>
<body>

    <!--home-content-->
    <div class="home-info">
        <section class="welcome">
            <img src="../images/Slider1.jpg" alt="user">
            <h1>Welcome to PetHug Veterinary Hospital!</h1><br>
            <p>We are dedicated to providing the best care for your pets. Explore our services and manage your appointments effortlessly.</p>
        </section>

        <!-- Main features section -->
        <div class="features">
            <h1>Features</h1>

            <div class="cards">
                <div class="card">
                    <img src="../images/animal.png" alt="View Pets">
                    <h3>View Pets</h3>
                    <p>Manage your pets' profiles, vaccination details, and health records.</p>
                    <a href="viewPets.php">View Pets</a>
                </div>
            
                <div class="card">
                    <img src="../images/service_16040658.png" alt="Add Pet">
                    <h3>Add Pets</h3>
                    <p>Add new pets and create their profiles instantly.</p>
                    <a href="add_pets.php">View Pets</a>
                </div>

                <div class="card">
                    <img src="../images/calendar_10057943.png" alt="Make Appointment">
                    <h3>Make Appointment</h3>
                    <p>Schedule a visit or consultation with our veterinarians.</p>
                    <a href="makeAppointment.php">Schedule Appointment</a>
                </div>

                <div class="card">
                    <img src="../images/outgoing-call_12406886.png" alt="Schedule Consultations">
                    <h3>Schedule Consultations</h3>
                    <p>Get expert advice from our veterinarians from the comfort of your home.</p>
                    <a href="consultation_form.php">Consult Now</a>
                </div>

                <div class="card">
                    <img src="../images/dog.png" alt="Request Hostel">
                    <h3>Request Hostel</h3>
                    <p>Leave your pet in good hands with our reliable boarding services.</p>
                    <a href="request_hostel.php">Request Hostel</a>
                </div>

                <div class="card">
                    <img src="../images/veterinary.png" alt="Medical Records">
                    <h3>Medical Records</h3>
                    <p>Access detailed medical reports for your pets and track their health.</p>
                    <a href="medical_records.php">View Medical Records</a>
                </div>
                
                <div class="card">
                    <img src="../images/bill_6295833.png" alt="View Billing">
                    <h3>View Billing</h3>
                    <p>Keep track of your bills and make secure payments easily.</p>
                    <a href="bill.php">View Billing</a>
                </div>

                <div class="card">
                    <img src="../images/payment.png" alt="Pending Payments">
                    <h3>Pending Payments</h3>
                    <p>Keep track of your bills and find payments approved or not. (This is for online bank transfer and cash payments.)</p>
                    <a href="pending_payments.php">Pending Payments</a>
                </div>

                <div class="card">
                    <img src="../images/notification.png" alt="Notifications">
                    <h3>Notifications</h3>
                    <p>Stay updated with reminders and important alerts for your pets.</p>
                    <a href="user_notifications.php">Check Notifications</a>
                </div>
            </div>
        </div>

    <!-- Sections to go to About, Services, Contact -->
    <div class="nav-to-about-services-contact">
        <h1>Get to Know Us</h1>
        <section class="home-features">
            <div class="feature-card">
                <img src="../images/about.png" alt="About Us">
                <h2>Learn More About Us</h2>
                <p>Discover our story, our team, and our dedication to pet care.</p>
                <a href="../about.php" class="btn">Learn More</a>
            </div>

            <div class="feature-card">
                <img src="../images/services.png" alt="Services">
                <h2>Our Services</h2>
                <p>Explore the range of services we offer for your beloved pets.</p>
                <a href="../services.php" class="btn">Explore Services</a>
            </div>

            <div class="feature-card">
                <img src="../images/contact.png" alt="Contact Us">
                <h2>Get In Touch</h2>
                <p>Have any questions? Reach out to us anytime.</p>
                <a href="../contact.php" class="btn">Contact Us</a>
            </div>
        </section>
    <div>

    <script src="../javascript_A/home.js"></script>
</body>
</html>

<!--footer-->
<?php include_once "footer_user.php" ?>

<?php $conn->close(); ?>