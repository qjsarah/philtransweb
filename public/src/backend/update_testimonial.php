<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $content = $_POST['test_content'];
  $name = $_POST['test_name'];
  $role = $_POST['roles'];
  $stars= $_POST['stars'];

  $stmt = $conn->prepare("UPDATE testimonials_table SET content = ?, name = ?, role = ?, stars = ? WHERE id = ?");
  $stmt->bind_param("ssssii", $content, $name, $role, $stars, $id);

  if ($stmt->execute()) {
    header("Location: ../index.php");
    exit();
  } else {
    echo "Error updating card.";
  }

  $stmt->close();
  $conn->close();
} 