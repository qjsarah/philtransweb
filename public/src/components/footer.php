<?php
include 'backend/config.php'; // adjust path if needed

// Fetch background color from database
$contactBg = '#000066'; // fallback default
$result = $conn->query("SELECT content FROM cfs WHERE key_name = 'contact_bg'");
if ($result && $row = $result->fetch_assoc()) {
    $contactBg = $row['content'];
}
?>

<footer class="text-center text-white" style="background-color: <?= htmlspecialchars($contactBg) ?>;">
    <div class="container py-3">
        <!-- Footer Text -->
        <div class="w-75 d-flex flex-column flex-md-row text-center justify-content-md-between mx-auto">
            <p>© 2025 PhilTransInc. All Rights Reserved</p>
            <p>Designed & Developed By BB 88 Advertising and Digital Solutions Inc.</p>
        </div>
    </div>
</footer>
