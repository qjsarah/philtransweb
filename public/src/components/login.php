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
    <link rel="stylesheet" href="../../main/style/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #BF0D3D;">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row w-100 justify-content-center"
            style="max-width: 1000px; height: 500px; background-color: #ffffff;
                   border-radius: 20px; box-shadow: 0 0 20px #000000;
                   border: 3px solid #BF0D3D;"> <!-- Border matches input boxes -->
            
            <!-- Left: Login Form -->
            <div class="col-md-6 d-flex flex-column justify-content-center px-4 py-5">
                <h2 class="text-center mb-5 fw-semibold" style="color:#BF0D3D;">ADMIN</h2>
                <form id="login-form" class="w-100">
                    
                    <!-- Email with icon -->
                    <div class="mb-4" style="position: relative;">
                        <div style="position: relative;">
                            <i class="bi bi-envelope-fill"
                                style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%); 
                                       color: #BF0D3D; font-size: 25px;"></i>
                            <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                                        height: 60%; width: 1px; background-color: #BF0D3D;"></div>
                            <input type="email" class="form-control"
                                style="background-color: #ffffff; border: 3px solid #BF0D3D;
                                       padding-left: 55px; height: 50px; font-size: 16px;"
                                id="email" placeholder="Email">
                        </div>
                    </div>

                    <!-- Password with icon -->
                    <div class="mb-4">
                        <div style="position: relative;">
                            <i class="bi bi-lock-fill"
                                style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%); 
                                       color: #BF0D3D; font-size: 25px;"></i>
                            <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                                        height: 60%; width: 1px; background-color: #BF0D3D;"></div>
                            <input type="password"
                                id="password"
                                class="form-control"
                                placeholder="Password"
                                style="background-color: #ffffff; border: 3px solid #BF0D3D;
                                       padding-left: 55px; padding-right: 50px;
                                       height: 50px; font-size: 16px;">
                            
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
                                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%);
                                    font-size: 25px; color: #BF0D3D; cursor: pointer;"></i>
                        </div>
                    </div>

                    <!-- Remember Me -->
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

                    <!-- Login Button -->
                    <button type="submit"
                        class="btn border-3 rounded-2 w-100 py-2"
                        style="background-color: #BF0D3D; height: 50px; font-size: 16px;
                               font-weight: bold; border: solid #BF0D3D; color: #ffffff; 
                               transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='5px 5px';"
                        onmouseout="this.style.backgroundColor='#BF0D3D'; this.style.color='#ffffff'; this.style.boxShadow='none'">
                        LOG IN
                    </button>

                </form>
                
          <div class="text-center mt-4">
            <p style="color: #464646ff;">Don't have an account? <a href="register.php"
                style="color: #BF0D3D; font-weight: 700;">Sign Up</a></p>
          </div>
            </div>  

            

            <!-- Right: Logo/Image -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-4">
                <div class="d-flex flex-column align-items-center">
                    <img src="../../main/images/login_section/philtranslogo.png" alt="Philtrans Logo"
                        class="img-fluid rounded-4 mb-3"
                        style="max-height: 80px;">
                    
                    <img src="../../main/images/login_section/philtransimage.png" alt="Philtrans Image"
                        class="img-fluid rounded-4"
                        style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

    <script>
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!email || !password) {
        Swal.fire({
            html: `<h2 class="swal-custom-title">Error!</h2>
                   <p class="swal-custom-text">All Fields Required!</p>`,
            showConfirmButton: true,
            confirmButtonText: 'Try Again',
            background: '#ffffff',
            color: '#BF0D3D',
            buttonsStyling: false,
            imageUrl: '../../main/images/register_section/registerimage.png',
            imageHeight: 200,
            imageAlt: 'Top Image',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                content: 'swal-custom-text',
                confirmButton: 'swal-button-btn ok-btn',
            },
            didOpen: () => {
                const img = Swal.getImage();
                img.style.marginTop = '-110px';
                const separator = document.createElement('div');
                separator.style.height = '2px';
                separator.style.width = '100%';
                separator.style.backgroundColor = '#BF0D3D';
                separator.style.borderRadius = '5px';
                const popup = Swal.getPopup();
                popup.insertBefore(separator, popup.querySelector('.swal-custom-title'));
            }
        });
        return;
    }

    // AJAX call for login
    $.ajax({
        url: '../backend/checklogin.php',
        method: 'POST',
        data: { email, password },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    html: `<h2 class="swal-custom-title">Login Successfully!</h2>
                           <p class="swal-custom-text">Redirecting...</p>`,
                    showConfirmButton: false,
                    timer: 1500,
                    background: '#ffffff',
                    color: '#BF0D3D',
                    imageUrl: '../../main/images/login_section/philtransimage.png',
                    imageHeight: 200,
                    imageAlt: 'Top Image',
                    customClass: {
                        popup: 'swal-custom-popup'
                    },
                    didOpen: () => {
                        const img = Swal.getImage();
                        img.style.marginTop = '-110px';
                        const separator = document.createElement('div');
                        separator.style.height = '2px';
                        separator.style.width = '100%';
                        separator.style.backgroundColor = '#BF0D3D';
                        separator.style.borderRadius = '5px';
                        const popup = Swal.getPopup();
                        popup.insertBefore(separator, popup.querySelector('.swal-custom-title'));
                    }
                }).then(() => {
                    window.location.href = '../index.php';
                });
            } else {
                Swal.fire({
                    html: `<h2 class="swal-custom-title">Invalid Email or Password!</h2>
                           <p class="swal-custom-text">Wrong Credentials...</p>`,
                    confirmButtonText: 'Try Again',
                    background: '#ffffff',
                    color: '#BF0D3D',
                    buttonsStyling: false,
                    imageUrl: '../../main/images/login_section/philtransimage.png',
                    imageHeight: 200,
                    imageAlt: 'Top Image',
                    customClass: {
                        popup: 'swal-custom-popup',
                        confirmButton: 'swal-button-btn ok-btn'
                    },
                    didOpen: () => {
                        const img = Swal.getImage();
                        img.style.marginTop = '-110px';
                        const separator = document.createElement('div');
                        separator.style.height = '2px';
                        separator.style.width = '100%';
                        separator.style.backgroundColor = '#BF0D3D';
                        separator.style.borderRadius = '5px';
                        const popup = Swal.getPopup();
                        popup.insertBefore(separator, popup.querySelector('.swal-custom-title'));
                    }
                });
            }
        },
    });
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

