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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #BF0D3D;">
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center"
      style="max-width: 1000px; height: 620px; background-color: #ffffff; border-radius: 25px; box-shadow: 0 0 10px #BF0D3D;">

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
      <div class="col-md-6 d-flex flex-column justify-content-center px-4 py-5">
        <h2 class="text-center mb-4 fw-semibold" style="color:#BF0D3D;">REGISTER</h2>
        <form id="registerForm" class="w-100">
          <div class="mb-4">
            <label for="name" class="form-label" style="color: #BF0D3D;">FULL NAME</label>
            <input type="text" name="name" class="form-control"
              style="background-color: #ffffff; border: none; border: 3px solid #BF0D3D; color: #BF0D3D;"
              id="name" placeholder="Enter your full name">
          </div>

          <div class="mb-4">
            <label for="email" class="form-label" style="color: #BF0D3D;">EMAIL</label>
            <input type="email" name="email" class="form-control"
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
        }"
      style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
        font-size: 1.3rem; color: #BF0D3D; cursor: pointer;"></i>
  </div>
</div>

         <div class="mb-4">
  <label for="confirmPassword" class="form-label" style="color: #BF0D3D;">CONFIRM PASSWORD</label>
  <div style="position: relative;">
    <input type="password"
      id="confirmPassword"
      class="form-control"
      placeholder="Confirm your password"
      style="background-color: #ffffff; border: none; border: 3px solid #BF0D3D; color: #BF0D3D; padding-right: 50px;">
    <i class="bi bi-eye-fill"
      id="toggleConfirmPassword"
      onclick="
        const confirmPwd = document.getElementById('confirmPassword');
        const icon = this;
        if (confirmPwd.type === 'password') {
          confirmPwd.type = 'text';
          icon.classList.remove('bi-eye-fill');
          icon.classList.add('bi-eye-slash-fill');
        } else {
          confirmPwd.type = 'password';
          icon.classList.remove('bi-eye-slash-fill');
          icon.classList.add('bi-eye-fill');
        }"
      style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
        font-size: 1.3rem; color: #BF0D3D; cursor: pointer;"></i>
  </div>
</div>

          <button type="submit" class="btn border-3 rounded-2 w-100 py-2"
            style="background-color: #ffffff; font-weight: bold; border: solid #BF0D3D; color: #BF0D3D; transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;"
            onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='5px 5px';"
            onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#BF0D3D'; this.style.boxShadow='none'">
            REGISTER
          </button>
        </form>

        <div class="text-center mt-3">
          <small style="color: #464646ff;">Already have an account? <a href="login.php"
              style="color: #BF0D3D; font-weight: 600;">Login</a></small>
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
                console.error("AJAX error:", xhr.responseText); 
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong, please try again later.",
                });
            }

            });
        });
    </script>
    <script>
  function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    }
  }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>