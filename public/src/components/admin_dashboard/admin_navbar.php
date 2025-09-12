<?php 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../../main/style/main.css">

  <style>
    /* Sidebar */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 300px;
      height: 100vh;
      border-right: 3px solid #BF0D3D;
      display: flex;
      flex-direction: column;
      padding-top: 30px;
      background: #fff;
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    /* Logo */
    #sidebar .logo img {
      width: 240px;
      height: 60px;
    }

    /* Sidebar nav list */
    #sidebarContent {
      flex-grow: 1;
      list-style: none;
      padding-left: 0;
      margin-top: 50px;
    }

    #sidebar li {
      margin: 15px 0;
    }

    /* Shared nav link style */
    #sidebar .nav-link {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      width: calc(100% - 40px);
      margin: 0 20px;
      padding: 13px 10px;
      font-size: 1.4rem;
      color: #BF0D3D;
      border-radius: 15px;
      background: transparent;
      transition: background-color 0.25s ease, color 0.25s ease;
    }

    #sidebar .nav-link i {
      margin-right: 12px;
      font-size: 1.6rem;
      color: #BF0D3D;
      transition: color 0.3s;
    }

    #sidebar .nav-link:hover {
      background-color: #BF0D3D;
      color: #fff;
    }

    #sidebar .nav-link:hover i {
      color: #fff;
    }

    .logout-section {
      margin-top: auto;
      margin-bottom: 20px;
      cursor: pointer;
    }

    /* Main content */
    #mainContent {
      margin-left: 300px;
      padding: 100px 30px 30px;
      transition: margin-left 0.3s ease;
    }

    /* Toggle button */
    #toggleBtn {
      position: fixed;
      top: 30px;
      left: calc(300px - 32px);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 3px solid #BF0D3D;
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 9999;
      transition: left 0.3s ease;
    }

    .bar {
      display: block;
      width: 30px;
      height: 4px;
      margin: 6px 0;
      background-color: #BF0D3D;
      transition: all 0.3s ease;
    }

    #toggleBtn.open .bar1 { transform: rotate(45deg) translate(6px, 6px); }
    #toggleBtn.open .bar2 { opacity: 0; }
    #toggleBtn.open .bar3 { transform: rotate(-45deg) translate(7px, -7px); }
  </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
  <!-- Logo -->
  <div class="logo d-flex align-items-center justify-content-center">
    <img src="../../../main/images/admin_dashboard/admin_logo.png" alt="Logo"
    style="width: 240px; height: 60px; margin-right:20px;">
  </div>

  <!-- Navigation -->
  <ul id="sidebarContent">
    <li><a class="nav-link" href="home_archive.php"><i class="bi bi-house"></i>Home</a></li>
    <li><a class="nav-link" href="download_archive.php"><i class="bi bi-download"></i>Download</a></li>
    <li><a class="nav-link" href="intro_archive.php"><i class="bi bi-file-earmark-text"></i>Introduction</a></li>
    <li><a class="nav-link" href="aboutus_archive.php"><i class="bi bi-info-circle"></i>About</a></li>
    <li><a class="nav-link" href="mvision_archive.php"><i class="bi bi-eye"></i>Mission & Vision</a></li>
    <li><a class="nav-link" href="services_archive.php"><i class="bi bi-gear"></i>Services</a></li>
    <li><a class="nav-link" href="contact_archive.php"><i class="bi bi-envelope"></i>Contact</a></li>
    <li><a class="nav-link" href="messages.php"><i class="bi bi-chat-left-text"></i>Messages</a></li>
  </ul>

  <!-- Logout -->
  <div class="logout-section">
    <a class="nav-link logoutBtn">
      <i class="bi bi-box-arrow-right"></i>Logout
    </a>
  </div>
</div>

<!-- Hamburger -->
<button id="toggleBtn" aria-label="Toggle Sidebar">
  <span class="bar bar1"></span>
  <span class="bar bar2"></span>
  <span class="bar bar3"></span>
</button>

<!-- Main content -->
<div id="mainContent">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutButtons = document.querySelectorAll(".logoutBtn");

    logoutButtons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault(); 

            Swal.fire({
              html: `<h2 class="swal-custom-title">Are you sure?</h2>
                     <p class="swal-custom-text">You will be logged out of your account.</p>`,
              icon: null,
              showCancelButton: true,
              confirmButtonText: 'Logout',
              cancelButtonText: 'Cancel',
              background: '#ffffff',
              color: '#BF0D3D',
              buttonsStyling: false,
              imageUrl: '../../../main/images/admin_dashboard/admin_image.png', 
              imageHeight: 200,
              imageAlt: 'Top Image',
              customClass: {
                  popup: 'swal-custom-popup',
                  confirmButton: 'swal-button-btn ok-btn',
                  cancelButton: 'swal-button-btn cancel-btn'
              },
              didOpen: () => {
                  const img = Swal.getImage();
                  img.style.marginTop = '-110px'; 
                  const separator = document.createElement('div');
                  separator.style.height = '4px';
                  separator.style.width = '100%';
                  separator.style.backgroundColor = '#BF0D3D';
                  separator.style.borderRadius = '5px';
                  const popup = Swal.getPopup();
                  popup.insertBefore(separator, popup.querySelector('.swal2-title'));
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  Swal.fire({
                     html: `<h2 class="swal-custom-title">Logged Out!</h2>
                            <p class="swal-custom-text">You have successfully logged out.</p>`,
                      icon: null,
                      showConfirmButton: false,
                      timer: 1500,
                      background: '#ffffff',
                      color: '#BF0D3D',
                      imageUrl: '../../../main/images/admin_dashboard/admin_image.png', 
                      imageHeight: 200,
                      imageAlt: 'Top Image',
                      customClass: {
                          popup: 'swal-custom-popup'
                      },
                      didOpen: () => {
                          const img = Swal.getImage();
                          img.style.marginTop = '-110px'; 
                          const separator = document.createElement('div');
                          separator.style.height = '4px';
                          separator.style.width = '100%';
                          separator.style.backgroundColor = '#BF0D3D';
                          separator.style.borderRadius = '5px';
                          const popup = Swal.getPopup();
                          popup.insertBefore(separator, popup.querySelector('.swal2-title'));
                      }
                  }).then(() => {
                      window.location.href = "../../backend/logout.php";
                  });
              }
          });
        });
    });
});
</script>

<script>
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const btn = document.getElementById("toggleBtn");
    const sidebarWidth = 298;

    let isOpen = true;

    btn.addEventListener("click", () => {
      btn.classList.toggle("open");

      if (isOpen) {
        sidebar.style.transform = `translateX(-${sidebarWidth}px)`;
        mainContent.style.marginLeft = "0";
        btn.style.left = "10px";
        isOpen = false;
      } else {
        sidebar.style.transform = "translateX(0)";
        mainContent.style.marginLeft = sidebarWidth + "px";
        btn.style.left = (sidebarWidth - btn.offsetWidth/2) + "px";
        isOpen = true;
      }
    });
</script>

<script src="../../../main/scripts/bootstrap.bundle.min.js"></script>
<script src="../../../main/scripts/swal.js"></script>
</body>
</html>
