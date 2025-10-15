<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Make sure the PHPMailer folder is in the same directory as this file
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        header("Location: index.html?message=" . urlencode($message));
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yourgmail@gmail.com';  // Your Gmail address
        $mail->Password = 'your-app-password';   // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email details
        $mail->setFrom('yourgmail@gmail.com', 'Dating Dynamics');
        $mail->addAddress('itzrocky487@gmail.com');  // Where you want to receive subscriber emails
        $mail->Subject = 'New Newsletter Subscriber';
        $mail->Body = "A new subscriber joined Dating Dynamics:\n\nEmail: $email";

        $mail->send();
        $message = "Thank you for subscribing!";
    } catch (Exception $e) {
        $message = "Mailer Error: " . $mail->ErrorInfo;
    }

    // Redirect back to your site with message
    header("Location: index.html?message=" . urlencode($message));
    exit;
}
?>
