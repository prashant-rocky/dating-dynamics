<?php
// Database connection
$servername = "localhost";
$username = "root";              // Change if needed
$password = "";                  // Change if needed
$dbname = "dating-dynamics";     // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("<p class='error-msg'>Database connection failed!</p>");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validate email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Check for duplicate entry
        $check = $conn->prepare("SELECT * FROM subscribe WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<p class='error-msg'>You’re already subscribed! 🌴</p>";
        } else {
            // Insert new subscriber
            $stmt = $conn->prepare("INSERT INTO subscribe (email) VALUES (?)");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                echo "<p class='success-msg'>Thank you for subscribing! 🎉</p>";
            } else {
                echo "<p class='error-msg'>Something went wrong. Please try again later.</p>";
            }

            $stmt->close();
        }
        $check->close();

    } else {
        echo "<p class='error-msg'>Please enter a valid email address.</p>";
    }
}

$conn->close();
?>
