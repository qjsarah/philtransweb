<?php
include 'config.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');


    // Insert message into DB
    $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    
    if ($stmt->execute()) {
    header("Location: ../index.php#contacts?status=sent");
    exit;
} else {
    header("Location: ../index.php#contacts?status=error");
    exit;
}

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../index.php#contacts");
    exit;
}
?>
