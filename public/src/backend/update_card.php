<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  $stmt = $conn->prepare("UPDATE card_table SET title = ?, content = ? WHERE id = ?");
  $stmt->bind_param("ssi", $title, $content, $id);

  if ($stmt->execute()) {
    header("Location: ../index.php#services");
    exit();
  } else {
    echo "Error updating card.";
  }

  $stmt->close();
  $conn->close();
} 
