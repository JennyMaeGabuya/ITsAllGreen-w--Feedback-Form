<?php

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$name = 'itsallgreen';

// Establish database connection
$conn = new mysqli($host, $user, $password, $name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set your email address where you want to receive the form submissions
$receiving_email_address = 'withitsallgreen@gmail.com';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize form data to prevent injection attacks
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $subject = htmlspecialchars($_POST['subject']);
  $message = htmlspecialchars($_POST['message']);

  // Insert data into the database
  $sqlInsert = "INSERT INTO submissions (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sqlInsert) === TRUE) {
    // Send email notification
    $email_content = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
    $headers = "From: $email" . "\r\n" . "Reply-To: $email" . "\r\n" . "X-Mailer: PHP/" . phpversion();

    // Use mail() function to send email
    mail($receiving_email_address, $subject, $email_content, $headers);

    // Redirect to thank you page
    header('Location: ../index.html');
    exit();
  } else {
    // Handle database insertion failure
    die('Error: ' . $conn->error);
  }
}

// If the form is not submitted, the user accessed the script directly
die('Access denied');
