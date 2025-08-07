<?php session_start(); ?>
<?php if (isset($_SESSION['user_id'])): ?>
  <div style="position: fixed; top: 10px; left: 10px; z-index: 1000;">
    <a href="backend/logout.php" class="btn btn-danger">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Philtrans App</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../public/main/style/main.css">
  <link rel="stylesheet" href="../../public/node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../../public/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <script src="../../public/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../../public/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../../public/main/scripts/data.js"></script>
  <script src="backend/script.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</head>
<body class="download">

    <?php include 'components/navbar.php'; ?>
    <section id="#">
      <?php 
        include 'components/download.php'; 
        include 'components/ads/ads_1.php';
        include 'components/welcome.php'; 
       ?>
    </section>

    <section id="about">
      <?php include 'components/about.php'; ?>
    </section>

    <section id="missionvission">
      <?php include 'components/mission_vission.php'; ?>
    </section>

    <section id="services">
      <?php 
        include 'components/services.php'; 
        include 'components/ads/ads_2.php';
      ?>
    </section>

    <section id="testimonial">
      <?php include 'components/testimonial.php'; ?>
    </section>

    <section id="contact">
      <?php include 'components/contact.php'; ?>
    </section>

    <section id="footer">
      <?php include 'components/footer.php'; ?>
    </section>
    
  <script src="../../public/main/scripts/bootstrap.bundle.min.js"></script> 
  <script> //for modal backdrop kase grabe na un source: https://stackoverflow.com/questions/10636667/bootstrap-modal-appearing-under-background
  //BAWAL ITAAS PLEASE
    $(document).on('show.bs.modal', '.modal', function () {
      $(this).appendTo('body');
    });

    document.querySelectorAll('.cms-image-input').forEach(input => { //CROPPERRRR
      input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const cmsKey = this.getAttribute('data-cms-key');

        const reader = new FileReader();
        reader.onload = () => {
          // Save base64 image and cmsKey to sessionStorage
          sessionStorage.setItem('tempImage', reader.result);
          sessionStorage.setItem('cmsKey', cmsKey);

          // Redirect to cropping page with cms_key in URL (optional, just for clarity)
          window.location.href = `components/imagecropper.php?cms_key=${cmsKey}`;
        };
        reader.readAsDataURL(file);
      });
    });
  </script>
</body>
</html>