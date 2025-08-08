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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #BF0D3D;">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row w-100 justify-content-center"
            style="max-width: 1000px; height: 500px; background-color: #ffffff; border-radius: 25px; box-shadow: 0 0 10px #BF0D3D;">
            
            <!-- Left: Login Form -->
            <div class="col-md-6 d-flex flex-column justify-content-center px-4 py-5">
                <h2 class="text-center mb-4 fw-semibold" style="color:#BF0D3D;">ADMIN LOGIN</h2>
                <form id="login-form" class="w-100">
                    <div class="mb-4">
                        <label for="email" class="form-label" style="color: #BF0D3D;">EMAIL</label>
                        <input type="email" class="form-control"
                            style="background-color: #ffffff; border: none; border: 3px solid #BF0D3D; color: #BF0D3D;"
                            id="email" placeholder="Enter your email">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label" style="color: #BF0D3D;">PASSWORD</label>
                        <div style="position: relative;">
                            <input type="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter your password"
                                style="background-color: #ffffff; border: none; border: 3px solid #BF0D3D; color: #BF0D3D; padding-right: 50px;">
                            
                            <i class="bi bi-eye-fill"
                                id="togglePassword"
                                onclick="
                                    const pwd = document.getElementById('password');
                                    const icon = this;
                                    if (pwd.type === 'password') {
                                        pwd.type = 'text';
                                        icon.classList.remove('bi-eye-fill');
                                        icon.classList.add('bi-eye-slash-fill');
                                    } else {
                                        pwd.type = 'password';
                                        icon.classList.remove('bi-eye-slash-fill');
                                        icon.classList.add('bi-eye-fill');
                                    }
                                "
                                style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
                                    font-size: 1.3rem; color: #BF0D3D; cursor: pointer;"></i>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox"
                            class="form-check-input"
                            id="rememberMe"
                            style="cursor: pointer; accent-color: #BF0D3D; border: 3px solid #BF0D3D;">
                        <label class="form-check-label"
                            for="rememberMe"
                            style="color: #464646ff; cursor: pointer;">
                            Remember me
                        </label>
                    </div>

                    <button type="submit"
                        class="btn border-3 rounded-2 w-100 py-2"
                        style="background-color: #ffffff; font-weight: bold; border: solid #BF0D3D; color: #BF0D3D; transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='5px 5px';"
                        onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='none'">
                        LOG IN
                    </button>
                </form>
            </div>

            <!-- Right: Logo/Image -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-4">
                <div class="d-flex flex-column align-items-center">
                    <img src="../../main/images/login_section/philtranslogo.png" alt="Philtrans Logo"
                        class="img-fluid rounded-4 mb-3"
                        style="max-height: 80px;">
                    
                    <img src="../../main/images/login_section/philtransimage.png" alt="Philtrans Image"
                        class="img-fluid rounded-4"
                        style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const button = event.target;
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                button.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                button.textContent = "Show";
            }
        }
    </script>

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
                    }
                },
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
