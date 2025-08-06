<!-- Cropper Modal -->
<?php // include 'navbar.php' ?>
<div id="cropModal" style="display:none;">
  <img id="cropperTarget" style="max-width: 100%;">
  <button class="btn btn-primary mt-2" onclick="cropAndUpload()">Crop & Upload</button>
  <button type="button" class="btn btn-primary mt-2" onclick="cancel()">Cancel</button>
</div>

<!-- Hidden Form -->
<form id="ads-upload" method="POST" action="backend/savecms.php" enctype="multipart/form-data" style="display:none;">
  <input type="hidden" name="cms_key" id="cmsKeyField">
  <input type="hidden" name="cropped_image" id="croppedImageField">
</form>
<script src="../main/scripts/adscropper.js"></script>
<script>
    function cancel(){
        const cropModal = document.getElementById('cropModal');
        cropModal.style.display = 'none';
    }
</script>


