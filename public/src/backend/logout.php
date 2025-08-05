<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Redirect back to homepage (adjust path as needed)
exit();
