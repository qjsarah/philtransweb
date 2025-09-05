<?php
include 'config.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit;
    }

    // Insert message into DB
    $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href='../index.php#contacts';</script>";
    } else {
        echo "<script>alert('Error: Could not send message.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../index.php#contacts");
    exit;
}
?>
