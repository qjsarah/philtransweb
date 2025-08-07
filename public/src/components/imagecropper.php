<!-- Cropper Modal -->
<?php // include 'navbar.php' ?>
<!-- <div id="cropModal">
  <img id="cropperTarget" style="max-width: 100%;">
  <button class="btn btn-primary mt-2" onclick="cropAndUpload()">Crop & Upload</button>
  <button type="button" class="btn btn-primary mt-2" onclick="cancel()">Cancel</button>
</div> -->

<!-- Hidden Form -->
<!-- <form id="ads-upload" method="POST" action="backend/savecms.php" enctype="multipart/form-data" style="display:none;">
  <input type="hidden" name="cms_key" id="cmsKeyField">
  <input type="hidden" name="cropped_image" id="croppedImageField">
</form>
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
<script src="../../main/scripts/adscropper.js"></script>
<script>
    function cancel(){
        const cropModal = document.getElementById('cropModal');
        cropModal.style.display = 'none';
    }
</script> -->
<head>
  <link rel="stylesheet" href="../../../public/main/style/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
</head>
<div class="mt-3 container overflow-x-hidden">
  <h1 class="text-center">Crop Image</h1>
    <img id="cropperTarget" class="img-fluid">
  <br>
  <div class="text-end">
    <button onclick="cropAndUpload()" class="btn btn-primary">Crop & Upload</button>
    <button onclick="window.history.back()" class="btn btn-primary">Cancel</button>
  </div>
</div>
<script src="../../../public/main/scripts/bootstrap.bundle.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="../../main/scripts/adscropper.js"></script>
