<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--Include these links -->
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 fade-in">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-dark text-white text-center rounded-top-4 py-4">
                        <h4 class="card-title fw-bold mb-0">Sign up succesfull!</h4>
                    </div>
                    <h2 class="text-center rounded-top-4 py-4">You have successfully signed up!</h2>
                    <h3 class="text-center py-1">Kindly check your email for account confirmation.</h3>
                    <div class="card-footer text-center">
                        <small>Already have an account? <a href="login.php">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>