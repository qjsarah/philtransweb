<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM testimonials_table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: ../index.php");
exit();
?>