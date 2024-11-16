<?php
include_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine the form type (feedback or contact) based on submitted fields
    if (isset($_POST['rating']) && isset($_POST['feedback'])) {
        // Feedback Form Submission
        $rating = $_POST['rating'];
        $feedback_text = $_POST['feedback'];

        // Validate feedback data
        if (empty($rating) || empty($feedback_text)) {
            echo "Please fill in all fields.";
        } else {
            // Insert feedback into the feedback table
            $stmt = $conn->prepare("INSERT INTO feedback (rating, feedback_text) VALUES (?, ?)");
            $stmt->bind_param("is", $rating, $feedback_text);

            if ($stmt->execute()) {
                $feedback_id = $stmt->insert_id;

                // Insert notification for admin about the feedback
                $notification_stmt = $conn->prepare("INSERT INTO notifications (recipient_type, title, message, service_type, service_id) VALUES ('admin', ?, ?, 'feedback', ?)");
                $title = 'New Feedback Submission';
                $message = "A new feedback has been submitted with ID: $feedback_id. Please review it.";
                $notification_stmt->bind_param("ssi", $title, $message, $feedback_id);

                if ($notification_stmt->execute()) {
                    echo "Thank you for your feedback! Admin has been notified.";
                } else {
                    echo "Feedback submitted, but there was an error notifying the admin.";
                }

                $notification_stmt->close();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
        // Contact Form Submission
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Validate contact data
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            echo "Please fill in all fields.";
        } else {
            // Insert contact message into the contact_form table
            $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            if ($stmt->execute()) {
                $contact_id = $stmt->insert_id;

                // Insert notification for admin about the contact message
                $notification_stmt = $conn->prepare("INSERT INTO notifications (recipient_type, title, message, service_type, service_id) VALUES ('admin', ?, ?, 'contact', ?)");
                $title = 'New Contact Message';
                $message = "A new contact message has been submitted with ID: $contact_id. Please review it.";
                $notification_stmt->bind_param("ssi", $title, $message, $contact_id);

                if ($notification_stmt->execute()) {
                    // Redirect with a success message
                    header("Location: contact.php?status=success");
                    exit();
                } else {
                    echo "Contact message submitted, but there was an error notifying the admin.";
                }

                $notification_stmt->close();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "Invalid form submission.";
    }
}

$conn->close();
?>
