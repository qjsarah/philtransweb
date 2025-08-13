<?php session_start(); ?>


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
    <script src="../../public/main/scripts/bootstrap.bundle.min.js"></script> 
  <script src="backend/script.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="download">
  <div class="sticky-top py-2" >
    <?php include 'components/navbar.php'; ?>
  </div>

  </div>
    <section id="#" class="mb-5 pb-1">
      <?php 
        include 'components/download.php'; 
        include 'components/ads/ads_1.php';
      ?>
    </section>

    <section id="welcome">
       <?php 
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
    document.body.appendChild(document.getElementById('editTestimonial'));

    // document.querySelectorAll('.modal').forEach(modal => {
    //   modal.addEventListener('show.bs.modal', function () {
    //     localStorage.setItem('lastOpenedModal', `#${this.id}`);
    //   });
    // });

    // document.addEventListener('DOMContentLoaded', function () {
    //   const lastModal = localStorage.getItem('lastOpenedModal');
    //   if (lastModal) {
    //     const modalElement = document.querySelector(lastModal);
    //     if (modalElement) {
    //       const modalInstance = new bootstrap.Modal(modalElement);
    //       modalInstance.show();
    //     }
    //     localStorage.removeItem('lastOpenedModal');
    //   }
    // });
document.querySelectorAll('.save-button').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault(); // prevent default form submit immediately

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save your changes?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Saved!',
                    text: 'Your changes have been saved successfully.',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    const form = button.closest('form'); // find the form this button belongs to
                    if (form) {
                        form.submit();
                    }
                });
            }
        });
    });
});

const uploadBoxes = document.querySelectorAll(".uploadBox");
const fileInputs = document.querySelectorAll(".fileInput");

uploadBoxes.forEach((box, index) => {
  const input = fileInputs[index]; // Link each box to its file input

  // Click to open file dialog
  box.addEventListener("click", () => input.click());

  // ADD THIS: dragenter event to allow drop
  box.addEventListener("dragenter", (e) => {
    e.preventDefault();
    box.classList.add("dragover");
  });

  // Highlight on drag
  box.addEventListener("dragover", (e) => {
    e.preventDefault();
    box.classList.add("dragover");
  });

  box.addEventListener("dragleave", () => {
    box.classList.remove("dragover");
  });

  // Handle dropped files
  box.addEventListener("drop", (e) => {
    e.preventDefault();
    box.classList.remove("dragover");

    if (e.dataTransfer.files.length) {
      input.files = e.dataTransfer.files;

      // ADD THIS: Manually trigger change event on input
      const event = new Event('change');
      input.dispatchEvent(event);
    }
  });

  // Handle normal file selection
  input.addEventListener("change", () => {
    // No alert — just keeps the file in the input
  });
});


  </script>
</body>
</html>