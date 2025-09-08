<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../../public/main/style/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
</head>

<div class="mt-3 container overflow-x-hidden justify-content-center">
  <h1 class="mb-3">Crop Image:</h1>

  <!-- Image container -->
  <div class="d-flex justify-content-center mb-3">
    <img id="cropperTarget" class="img-fluid" style="max-width:100%; max-height:70vh;">
  </div>

  <!-- Buttons -->
  <div class="d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3">
  <button id="cancelBtn" 
          class="contact_button px-4 py-2 rounded text-dark w-100 w-md-auto" 
          style="border: 1px solid black;">
    Cancel
  </button>
  <button id="cropUploadBtn" 
        class="contact_button px-4 py-2 rounded text-dark w-100 w-md-auto" 
        style="border: 1px solid black;">
    Crop & Upload
  </button>
  </div>
</div>

<script src="../../../public/main/scripts/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../main/scripts/adscropper.js"></script>
<script src="../../main/scripts/swal_archive.js"></script>