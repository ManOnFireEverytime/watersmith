<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include the PHPMailer classes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs and sanitize them
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $company = htmlspecialchars(trim($_POST['company']));
    $budget = htmlspecialchars(trim($_POST['budget']));
    $message = htmlspecialchars(trim($_POST['msg']));

    // Set up PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                            // Use SMTP
        $mail->Host       = 'smtp.hostinger.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'mofe@axelcyber.com';               // SMTP username
        $mail->Password   = 'Mofecyber#001';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('mofe@axelcyber.com', 'Contact Form');
        $mail->addAddress('mofe@axelcyber.com', 'Your Name');   // Add recipient

        // File Attachment
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
        }

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Company:</strong> $company</p>
            <p><strong>Project Budget:</strong> $budget</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nCompany: $company\nProject Budget: $budget\nMessage:\n$message";

        // Send the email
        if ($mail->send()) {
            header('Location: contact.html');
            exit;
        } else {
            echo "There was an error sending your message.";
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
