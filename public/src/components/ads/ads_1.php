<?php
include 'backend/config.php';

// Fetch ads1 and ads2 from DB
$result = $conn->query("SELECT key_name, content FROM download WHERE key_name IN ('ads1', 'ads2')");
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<section class="mt-5">
  <div class="ad1 d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">

    <!-- Ad Image 1 -->
    <div>
    <!-- Display current image -->
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'placeholder1.jpg'); ?>"
            alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads1" style="max-width: 100%; height: auto;">

        <?php if (isset($_SESSION['user_id'])): ?>
          <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads1" accept="image/*">
        <?php endif; ?>
      </div>


    <!-- Ad Image 2 -->
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'placeholder2.jpg'); ?>" 
           alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads2" style="max-width: 100%; height: auto;">

       <?php if (isset($_SESSION['user_id'])): ?>
          <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads2" accept="image/*">
        <?php endif; ?>
    </div>

  </div>

</section>
<!-- Cropper Modal -->
  <div id="cropModal" style="display:none;">
    <img id="cropperTarget" style="max-width: 100%;">
    <button class="btn btn-primary mt-2" onclick="cropAndUpload()">Crop & Upload</button>
  </div>

  <!-- Hidden Form -->
  <form id="ads-upload" method="POST" action="backend/savecms.php" enctype="multipart/form-data" style="display:none;">
    <input type="hidden" name="cms_key" id="cmsKeyField">
    <input type="hidden" name="cropped_image" id="croppedImageField">
  </form>

