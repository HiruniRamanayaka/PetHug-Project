<?php
    session_start();

    // Check if the user is an admin or a regular user
    if (isset($_SESSION['admin_id'])) {
        // If it's an admin, destroy the admin session
        session_unset();  // Unset all session variables
        session_destroy();  // Destroy the session
        header("Location: ./admin/adminHome.php");  // Redirect to admin login page
    } elseif (isset($_SESSION['user_id'])) {
        // If it's a regular user, destroy the user session
        session_unset();  // Unset all session variables
        session_destroy();  // Destroy the session
        header("Location: index.php");  // Redirect to user homepage or login page
    }elseif (isset($_SESSION['dr_id'])) {
        // If it's a regular user, destroy the user session
        session_unset();  // Unset all session variables
        session_destroy();  // Destroy the session
        header("Location: ./doctor/doctorHome.php");  // Redirect to user homepage or login page
    }else {
        // If no session is found, redirect to the homepage
        header("Location: index.php");  // Redirect to homepage
    }
    exit();
?>
