<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header('Location: /philtransweb/public/src/index.php');
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

    <!-- Full-height container to center vertically -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100 fade-in">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5"> <!-- Wider column for "larger" effect -->
        <div class="card shadow-lg border-0 rounded-4">
            
            <!-- Header -->
            <div class="card-header bg-dark text-white text-center rounded-top-4 py-4">
            <h4 class="card-title fw-bold mb-0">Admin Login</h4>
            </div>

            <!-- Body -->
            <div class="card-body p-5">
            <form>
                <div class="form-floating mb-4">
                <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                </div>
                <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <button type="submit" class="btn btn-dark w-100 py-3 fs-5 rounded-3">Login</button>
            </form>
            </div>

            <!-- Footer -->
        </div>
        </div>
    </div>
    </div>


    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            $.ajax({
                url: '../backend/checklogin.php',
                method: 'POST',
                data: {
                    email: email,
                    password: password,
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading-indicator').show();
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success!",
                            icon: "success",
                            text: "Login successful. Redirecting...",
                        }).then(() => {
                            window.location.href = '../index.php';
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message || "Incorrect credentials.",
                        });
                    }},
            });
        });
    </script>
</body>
</html>