<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['test_content']);
    $name = trim($_POST['test_name']);
    $role = trim($_POST['roles']);
    $stars = filter_input(INPUT_POST, 'stars', FILTER_VALIDATE_INT);
    $stars = ($stars >= 1 && $stars <= 5) ? $stars : 5; // default to 5 if invalid

    $stmt = $conn->prepare("INSERT INTO testimonials_table (test_content, test_name, roles, stars) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $content, $name, $role, $stars);
    $stmt->execute();
}

header("Location: ../index.php#testimonial");
exit();
?>
