<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="beforeLogin_style/home-content.css" type="text/css">
    <?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';?>
</head>
<body>

    <!--header-->
    <?php include_once "header.php" ?>
    
    <!--hero section-->
    <div class="hero">
        <div class="hero-section">
            <h5>The Best Pet Care Services</h5>
            <h2>Care of Your Little Pets!</h2>
            <p>Receive a wide range of quality services for the care of your beloved pets. Let our expert help you ensure the health and happiness of your little friends.</p><br><br>
            <button class="btn"><a href="select_user_type_for_signup.php">Book Your Appoinment Now &nbsp;<i class="fas fa-arrow-right"></i></a></button>
        </div>

        <!--image mask-->
        <div class="image-mask-container">
            <div class="mask-1"></div>
            <div class="mask-2"></div>
            <div class="mask-3"></div>
            <div class="mask-4"></div>
            <div class="mask-5"></div>
        </div>
    </div>

    <!--Direct to register page-->
    <div id="toRegister">
        <h2>Need high-quality veterinary care you can trust?</h2>
        <div id="toRegisterLink">
            <a href="select_user_type_for_signup.php"><button>Register Now &nbsp;<i class="fas fa-arrow-right"></i></button></a>
        </div>
        <br><p>Walk-Ins Accepted!</p>
    </div>

    <!--Services-->
    <section class="services">
        <div id="service">
            <h2>Our Pet Care Services</h2><br>
            <p>Our team of dedicated professionals is committed to delivering the highest standards of veterinary medicine, using the latest technology and techniques. Explore our services below to discover how we can help keep your pet healthy and happy.</p>
        </div>
        
        <div class="services-container">
            <button class="service-card">
                <div class="icon"><i class="fas fa-syringe"></i></div>
                <h3>Vaccinations</h3><br>
                <p>Core and non-core vaccines to protect<br>your pets from preventable diseases.</p>
            </button>

            <button class="service-card">
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <h3>Examinations</h3><br>
                <p>Routine check-ups and wellness exams<br>for your pet’s overall health.</p>
            </button>

            <button class="service-card">
                <div class="icon"><i class="fas fa-paw"></i></div>
                <h3>Pet Boarding</h3><br>
                <p>Safe, comfortable, and supervised care<br>for your pets while you're away.</p>
            </button>
    
            <button class="service-card">
                <div class="icon"><i class="fas fa-stethoscope"></i></div>
                <h3>Consultations</h3><br>
                <p>Expert advice and care<br>for your pet’s health and behavior.</p>
            </button>
            <br><br>
            <button class="btn"><a href="services.php">View All Services</a></button>
        </div>
    </section>

    <!-- direct to about page-->
    <section>
        <div class="about">
            <div id="img-about">
                <h2>Envisioning a brighter future for pet care.</h2><br>
                <p>Our efforts have resulted in significant improvements in pet care. Will you be part of our journey?</p><br><br>
                <button class="btn"><a href="about.php">Learn More</a></button>
            </div>
            <img src="images/img2-homepage.jpg" alt="Pet Care">
        </div>
    </section>

    <!--promises-->
    <section class="promise-section">
        <div class="promise-title">
            <h1><strong>Our Promise</strong> to Our Patients</h1>
            <p>We’re honored to be a part of your pet’s healthy, happy life.</p>
        </div>
        <div class="promises">
            <div class="promise-box" id="promise-box1">
                <img src="icons/pet-care 1.png">
                <h2>Wellness Focus</h2>
                <p>We’re committed to preventative care: seeing your pet regularly, anticipating their needs, and treating health issues before they become bigger problems down the road.</p>
            </div>
            <div class="promise-box" id="promise-box2">
                <img src="icons/pet-care 2.png">
                <h2>Relationship Care</h2>
                <p>We take the time to get to know our patients and their humans. We listen carefully to your concerns and care for your pet as if they were our own.</p>
            </div>
            <div class="promise-box" id="promise-box3">
                <img src="icons/pet-care 3.png">
                <h2>Total Transparency</h2>
                <p>We keep you in the loop every step of the way. Labs, procedures, treatment options, and cost, we discuss everything with you so you can make informed decisions.</p>
            </div>
            <div class="promise-box" id="promise-box4">
                <img src="icons/pet-care 4.png">
                <h2>Quality Medicine</h2>
                <p>Your standards are high when it comes to your pet's care, and so are ours. We provide the highest quality clinical services, delivered by highly trained doctors, technicians, and staff.</p>
            </div>
        </div>
    </section>

    <!--social media-->
    <section class="stay-connected">
        <div class="social-media">
            <h2>Stay Connected!</h2>
            <div class="social-links">
                <a href="#" class="facebook"><img src="https://freepnglogo.com/images/all_img/facebook-logo.png" alt="Facebook">Like Us on Facebook</a>
                <a href="#" class="instagram"><img src="https://freepnglogo.com/images/all_img/1715965947instagram-logo-png%20(1).png" alt="Instagram">Follow us on Instagram</a>
                <a href="#" class="twitter"><img src="https://freepnglogo.com/images/all_img/1691832581twitter-x-icon-png.png" alt="Twitter">Follow us on Twitter</a>
            </div>
        </div>
    </section>
    

    <!--footer-->
    <?php include_once "footer.php"?>

</body>
</html>

