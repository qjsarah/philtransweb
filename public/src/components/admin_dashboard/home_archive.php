<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../main/style/main.css">
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<!-- Main content -->
<div id="mainContent">
  <h1 class="mb-4 display-3" style="color:#BF0D3D">Welcome to the Admin Dashboard</h1>
  <p class="display-6">Select a section from the sidebar to manage its archives.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../main/scripts/bootstrap.bundle.min.js"></script>
<script src="../../../main/scripts/swal.js"></script>
</body>
</html>
