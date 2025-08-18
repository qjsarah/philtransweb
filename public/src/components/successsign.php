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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #BF0D3D;">

    <div class="container d-flex align-items-center justify-content-center min-vh-100 fade-in">
        <div class="row w-100 justify-content-center" style="max-width: 600px;">
            <div class="col-12">


                <div class="card shadow-lg border-0 rounded-5"
                    style="background-color: #ffffff; border-radius: 25px; box-shadow: 0 0 10px #BF0D3D;">

                    <div class="text-center mt-3">
                    <img src="../../main/images/successsign_section/philtranslogo.png" alt="Philtrans Logo"
                        class="img-fluid"
                        style="max-height: 80px;">
                </div>


                    <!-- Card Body -->
                    <div class="card-body text-center px-4 py-4" style="color: #BF0D3D;">
                        <h2 class="fw-bold mb-3">You have successfully signed up!</h2>
                        <h5 class="mb-4" style="color: #464646;">Kindly check your email for account confirmation.</h5>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center bg-white rounded-bottom-4"
                        style="border-top: 3px solid #BF0D3D;">
                        <small style="color: #464646;">Already have an account?
                            <a href="login.php"
                                style="color: #BF0D3D; font-weight: 600; text-decoration: underline;">Login</a>
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>


</html>