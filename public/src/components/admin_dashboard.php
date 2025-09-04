<?php 
session_start(); 
if (isset($_SESSION['user_id'])): ?>
    
    <h1>Download Section</h1>
    <a href="admin_dashboard/download_archive.php">Download Section</a>

    <h1>Intro Section</h1>
    <a href="admin_dashboard/intro_archive.php">Intro Section</a>

    <h1>About Section</h1>
    <a href="admin_dashboard/aboutus_archive.php">About us Section</a>

    <h1>Mission Vision Section</h1>
    <a href="admin_dashboard/mvision_archive.php">Mission & Vision Section</a>

    <h1>Services Section</h1>
    <a href="admin_dashboard/services_archive.php">Services Section</a>

    <h1>Contact Section</h1>
    <a href="admin_dashboard/contact_archive.php">Contact Section</a>

<?php 
else: 
    header("Location: ../index.php");
    exit;
endif; 
?>
