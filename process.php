<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Validate
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Prepare email
    $to = "pvc@email.com";
    $subject = "New Contact Message";
    $body = "From: $name\nEmail: $email\nMessage:\n$message";

    // Try to send email
    if (mail($to, $subject, $body)) {
        echo "Message sent successfully!";
    } else {
        // Save to file if mail fails
        file_put_contents("messages.txt", $body . "\n---\n", FILE_APPEND);
        echo "Mail failed. Message saved to file.";
    }
} else {
    echo "Invalid request.";
}
?>