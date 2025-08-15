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
  <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Display current image -->
    <div class="ad1 d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
      <div>
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'ads_no_1.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads1" style="max-width: 100%; height: auto;">
      </div>
      <div>
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'ads_no_2.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads2" style="max-width: 100%; height: auto;">
      </div>
    </div>
    <!--EDIT BUTTOn-->
<div class="text-center mb-3 ad1">
  <button type="button" 
          class="contact_button rounded text-dark w-50 w-md-25 px-2 py-2 mt-2" 
          style="border-color: black;" 
          onclick="toggleEditAll(this)" 
          data-modal-target=".edit-ads-1">
    Change Advertisement
  </button>
</div>


  <!--Modal -->
      <div class="modal fade edit-ads-1" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" ><!-- Added modal-dialog-centered -->
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Advertisments Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-4">
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
          <div class="text-center">
            <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'ads_no_1.png'); ?>" 
                 alt="Ad Image" 
                 class="img-fluid mb-2 current-cms-img" 
                 data-cms-key="ads1" 
                 style="max-width: 100%; height: auto;">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads1" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </div>

          <div class="text-center">
            <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'ads_no_2.png'); ?>" 
                 alt="Ad Image" 
                 class="img-fluid mb-2 current-cms-img" 
                 data-cms-key="ads2" 
                 style="max-width: 100%; height: auto;">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads2" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php else: ?>
  <div class="ad1 d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'ads_no_1.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img " data-cms-key="ads1" style="max-width: 100%; height: auto;">
    </div>
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'ads_no_2.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads2" style="max-width: 100%; height: auto;">
    </div>
  </div>
<?php endif; ?>

</section>
<!-- Modal for Image Cropping -->
<!-- <div id="cropModal" class="modal fade" tabindex="1" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
    <div class="modal-content vh-100">
      <div class="modal-header">
        <h5 class="modal-title">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex align-items-center justify-content-center">
        <div>
          <img id="cropperTarget" class=" d-block mx-auto" alt="Image to crop" />
        </div>
      </div>
      <div class="modal-footer" accesskey="">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="cropAndUpload()">Crop and Upload</button>
      </div>
    </div>
  </div>
</div> -->