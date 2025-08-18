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
    <link rel="stylesheet" href="../../main/style/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #BF0D3D;">
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center"
      style="max-width: 1000px; height: 600px; background-color: #ffffff; border-radius: 20px; box-shadow: 0 0 20px #000000 ">

      <!-- Left: Logo/Image -->
      <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-4">
        <div class="d-flex flex-column align-items-center">
          <img src="../../main/images/register_section/registerlogo.png" alt="Philtrans Logo"
            class="img-fluid rounded-4 mb-3" style="max-height: 80px;">
          <img src="../../main/images/register_section/registerimage.png" alt="Philtrans Image"
            class="img-fluid rounded-4" style="max-height: 300px;">
        </div>
      </div>

      <!-- Right: Register Form -->
      <div class="col-md-6 d-flex align-items-center justify-content-center px-4">

        <div class="w-100">
          <h2 class="text-center mb-5 fw-semibold" style="color:#BF0D3D;">REGISTER</h2>
          <form id="registerForm" class="w-100">
            <!-- FULL NAME -->
            <div class="mb-4" style="position: relative;">
              <i class="bi bi-person-fill"
                 style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%);
                        color: #BF0D3D; font-size: 25px;"></i>
              <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                          height: 60%; width: 1px; background-color: #BF0D3D;"></div>
              <input type="text" name="name" class="form-control"
                     style="background-color: #ffffff; border: 3px solid #BF0D3D;
                            padding-left: 55px; height: 50px; font-size: 16px;"
                     id="name" placeholder="Enter your full name">
            </div>

            <!-- EMAIL -->
            <div class="mb-4" style="position: relative;">
              <i class="bi bi-envelope-fill"
                 style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%);
                        color: #BF0D3D; font-size: 25px;"></i>
              <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                          height: 60%; width: 1px; background-color: #BF0D3D;"></div>
              <input type="email" name="email" class="form-control"
                     style="background-color: #ffffff; border: 3px solid #BF0D3D;
                            padding-left: 55px; height: 50px; font-size: 16px;"
                     id="email" placeholder="Enter your email">
            </div>

            <!-- PASSWORD -->
            <div class="mb-4" style="position: relative;">
              <i class="bi bi-lock-fill"
                 style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%);
                        color: #BF0D3D; font-size: 25px;"></i>
              <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                          height: 60%; width: 1px; background-color: #BF0D3D;"></div>
              <input type="password" id="password" class="form-control"
                     placeholder="Enter your password"
                     style="background-color: #ffffff; border: 3px solid #BF0D3D;
                            padding-left: 55px; padding-right: 50px; height: 50px; font-size: 16px;">
              <i class="bi bi-eye-fill"
                 id="togglePassword"
                 onclick="const pwd=document.getElementById('password');const icon=this; if(pwd.type==='password'){pwd.type='text';icon.classList.replace('bi-eye-fill','bi-eye-slash-fill');} else{pwd.type='password';icon.classList.replace('bi-eye-slash-fill','bi-eye-fill');}"
                 style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%);
                        font-size: 25px; color: #BF0D3D; cursor: pointer;"></i>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-4" style="position: relative;">
              <i class="bi bi-lock-fill"
                 style="position: absolute; top: 50%; left: 13px; transform: translateY(-50%);
                        color: #BF0D3D; font-size: 25px;"></i>
              <div style="position: absolute; top: 50%; left: 48px; transform: translateY(-50%);
                          height: 60%; width: 1px; background-color: #BF0D3D;"></div>
              <input type="password" id="confirmPassword" class="form-control"
                     placeholder="Confirm your password"
                     style="background-color: #ffffff; border: 3px solid #BF0D3D;
                            padding-left: 55px; padding-right: 50px; height: 50px; font-size: 16px;">
              <i class="bi bi-eye-fill"
                 id="toggleConfirmPassword"
                 onclick="const pwd=document.getElementById('confirmPassword');const icon=this; if(pwd.type==='password'){pwd.type='text';icon.classList.replace('bi-eye-fill','bi-eye-slash-fill');} else{pwd.type='password';icon.classList.replace('bi-eye-slash-fill','bi-eye-fill');}"
                 style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%);
                        font-size: 25px; color: #BF0D3D; cursor: pointer;"></i>
            </div>

             <button type="submit"
                        class="btn border-3 rounded-2 w-100 py-2"
                        style="background-color: #BF0D3D; height: 50px; font-size: 16px;
                               font-weight: bold; border: solid #BF0D3D; color: #ffffff; 
                               transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='5px 5px';"
                        onmouseout="this.style.backgroundColor='#BF0D3D'; this.style.color='#ffffff'; this.style.boxShadow='none'">
                        SIGN UP
                    </button>
          </form>

          <div class="text-center mt-4">
            <p style="color: #464646ff;">Already have an account? <a href="login.php"
                style="color: #BF0D3D; font-weight: 700;">Sign In</a></p>
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
              html: `<h2 class="swal-modern-title">Incorrect Password!</h2>
                     <p class="swal-modern-text">Password do not match!</p>`,
              icon: null,
              confirmButtonText: 'Try Again',
              background: '#ffffff',
              color: '#BF0D3D',
              buttonsStyling: false,
              imageUrl: '../../main/images/login_section/logintrycicle.png', 
              imageHeight: 200,
              imageAlt: 'Top Image',
              customClass: {
                  popup: 'swal-custom-popup',
                  title: 'swal-modern-title',
                  content: 'swal-modern-text',
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
                  popup.insertBefore(separator, popup.querySelector('.swal2-title'));
              }
          });
          return;
      }

      $.ajax({
          url: '../backend/checkregister.php',
          method: 'POST',
          data: { name, email, password },
          success: function (response) {
              if (response.status === 'success') {
                  Swal.fire({
                      html: `<h2 class="swal-modern-title">Registered Successfully!</h2>
                             <p class="swal-modern-text">Redirecting...</p>`,
                      icon: null,
                      showConfirmButton: false,
                      timer: 1500,
                      background: '#ffffff',
                      color: '#BF0D3D',
                      imageUrl: '../../main/images/register_section/registerphiltrans.png', 
                      imageHeight: 200,
                      imageAlt: 'Top Image',
                      customClass: { popup: 'swal-custom-popup', title: 'swal-modern-title', content: 'swal-modern-text' },
                      didOpen: () => {
                          const img = Swal.getImage();
                          img.style.marginTop = '-110px'; 
                          const separator = document.createElement('div');
                          separator.style.height = '2px';
                          separator.style.width = '100%';
                          separator.style.backgroundColor = '#BF0D3D';
                          separator.style.borderRadius = '5px';
                          const popup = Swal.getPopup();
                          popup.insertBefore(separator, popup.querySelector('.swal2-title'));
                      }
                  }).then(() => { window.location.href = 'success.php'; });
              } else {
                  Swal.fire({ icon: "error", title: "Error", text: response.message, showConfirmButton: false, timer: 2000 });
              }
          },
          error: function () {
              Swal.fire({ icon: "error", title: "Oops...", text: "Something went wrong, please try again later.", showConfirmButton: false, timer: 2000 });
          }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
