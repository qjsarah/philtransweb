<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header('Location: download.php');
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
                        <h4 class="card-title fw-bold mb-0">Register</h4>
                    </div>
                    <div class="card-body p-5   ">
                        <form id="registerForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="name" class="form-control" id="email" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="name" class="form-control" id="password"
                                    placeholder="Create a password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="name" class="form-control" id="confirmPassword"
                                    placeholder="Confirm your password">
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2 fs-5 rounded-3">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Already have an account? <a href="login.php">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Passwords do not match!',
                });
                return;
                        }

                        $.ajax({
                url: '../backend/checkregister.php',
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    password: password,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Registration Successful!",
                            icon: "success",
                            text: response.message,
                        });
                        setTimeout(function () {
                            window.location.href = 'successsign.php';
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.message,
                        });
                    }
                },
                error: function (xhr, status, error) {
                console.error("AJAX error:", xhr.responseText); // 👈 THIS will tell us what's wrong
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong, please try again later.",
                });
            }

            });
        });
    </script>
</body>

</html>