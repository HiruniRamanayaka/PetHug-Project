<?php 
    session_start();
    include_once "../connection.php";
    //header
    include_once "header_user.php";
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
    <!--header-->
    <?php include_once "header_user.php" ?>

    <!--home-content-->
    <div class="home-info">
        <section class="welcome">
            <h1>Welcome to PetHug Veterinary Hospital!</h1><br>
            <p>We are dedicated to providing the best care for your pets. Explore our services and manage your appointments effortlessly.</p>
        </section>

        <!-- Main features section -->
        <div class="accordion">
            <h1>Features</h1>
            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">View Pets
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Manage your pets' profiles, vaccination details, and health records. <a href="viewPets.php">View More</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Add Pet
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Add new pets and create their profiles instantly. <a href="add_pets.php">Add Now</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Make Appointment
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Schedule a visit or consultation with our veterinarians. <a href="makeAppointment.php">Schedule Appointment</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Schedule Consultations
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Get expert advice from our veterinarians from the comfort of your home.<br> <a href="consultation_form.php">Consult Now</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Request Hostel
                    <i class="fas fa-chevron-down"></i></h2>
                <div class="accordion-content">
                    <p>Leave your pet in good hands with our reliable boarding services.<br> <a href="request_hostel.php">Request Hostel</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Medical Records
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Access detailed medical reports for your pets and track their health. <br><a href="medical_records.php">View Medical Records</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">View Billing
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Keep track of your bills and make secure payments easily. <a href="bill.php">View Billing</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Pending Payments
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Keep track of your bills and find payments approved or not. (This is for online bank transfer and cash payments.) <a href="pending_payments.php">Pending Payments</a></p>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" onclick="toggleAccordion(this)">Notifications
                    <i class="fas fa-chevron-down"></i>
                </h2>
                <div class="accordion-content">
                    <p>Stay updated with reminders and important alerts for your pets. <a href="user_notifications.php">Check Notifications</a></p>
                </div>
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
                <a href="../beforeLogin/about.php" class="btn">Learn More</a>
            </div>

            <div class="feature-card">
                <img src="../images/services.png" alt="Services">
                <h2>Our Services</h2>
                <p>Explore the range of services we offer for your beloved pets.</p>
                <a href="../beforeLogin/services.php" class="btn">Explore Services</a>
            </div>

            <div class="feature-card">
                <img src="../images/contact.png" alt="Contact Us">
                <h2>Get In Touch</h2>
                <p>Have any questions? Reach out to us anytime.</p>
                <a href="../beforeLogin/contact.php" class="btn">Contact Us</a>
            </div>
        </section>
    <div>

    <script src="../javascript_A/home.js"></script>
</body>
</html>

<!--footer-->
<?php include_once "footer_user.php" ?>

<?php $conn->close(); ?>