<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';?>
    <style> 
    
    /* General Footer Styles */
 footer {
     background-color: #262b6a; 
     color: #f0f8ff; 
     padding: 50px 0;
     font-family: Arial, sans-serif;
     margin-top: 50px;
 }
 
 .footer-container {
     display: flex;
     justify-content: space-between;
     flex-wrap: wrap;
     max-width: 1200px;
     margin: 0 auto;
     padding: 0 20px;
 }
 
 .footer-section {
     flex: 1 1 250px;
     margin: 20px;
 }
 
 .footer-section h4 {
     font-size: 20px;
     color: #fff;
     margin-bottom: 15px;
     border-bottom: 2px solid #3498db; 
     padding-bottom: 5px;
 }
 
 .footer-section p, .footer-section a, .footer-section li {
     font-size: 14px;
     color: #dcdde1; 
     line-height: 1.8;
 }
 
 .footer-section a {
     color: #3498db; 
     text-decoration: none;
 }
 
 .footer-section a:hover {
     color: #9b59b6; 
     text-decoration: underline;
 }
 
 .footer-section ul {
     list-style-type: none;
     padding: 0;
 }
 
 .footer-section li {
     margin: 5px 0;
 }
 
 /* Follow Us Section Icons */
 .footer-section img {
     width: 24px;
     height: 24px;
     margin-right: 15px;
     vertical-align: middle;
 }
 
 /* Footer Bottom Styles */
 .footer-bottom {
     background-color: #221b40; 
     color: #dcdde1; 
     text-align: center;
     padding: 20px 0;
     border-top: 1px solid #3498db; 
 }
 
 .footer-bottom p {
     margin: 0;
     font-size: 13px;
 }
 
 /* Responsive Design */
 @media (max-width: 768px) {
     .footer-container {
         flex-direction: column;
         align-items: center;
     }
     .footer-section {
         margin-bottom: 20px;
         text-align: center;
     }
 }
 
    
     </style>
</head>
<body>
    
    <!--footer-->
    <footer>
        <div class="footer-container">
            <!-- Contact Us Section -->
            <div class="footer-section contact-us">
                <h4>Contact Us</h4>
                <p><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;123 Pet Lane, Animal City, PA 12345</p>
                <p><i class="fas fa-phone"></i>&nbsp;&nbsp;Phone: +94 (234) 567-890</p>
                <p><i class="fas fa-envelope"></i>&nbsp;&nbsp;Email: info@pethugvet.com</p>
            </div>

            <!-- Quick Links Section -->
            <div class="footer-section quick-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Follow Us Section -->
            <div class="footer-section follow-us">
                <h4>Follow Us</h4>
                <a href="https://facebook.com" target="_blank"><img src="https://freepnglogo.com/images/all_img/facebook-logo.png" alt="Facebook"></a>
                <a href="https://instagram.com" target="_blank"><img src="https://freepnglogo.com/images/all_img/1715965947instagram-logo-png%20(1).png" alt="Instagram"></a>
                <a href="https://twitter.com" target="_blank"><img src="https://freepnglogo.com/images/all_img/1691832581twitter-x-icon-png.png" alt="Twitter"></a>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 PetHug Veterinary Hospital. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>