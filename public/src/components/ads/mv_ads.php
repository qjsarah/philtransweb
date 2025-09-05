<?php
include 'backend/config.php';

$keys = ['ads3', 'ads4'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM missionvision WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section>
    <!-- Ads -->
    <div class="text-center row justify-content-center align-items-center gap-3 pb-5">
      <div class="col-7 col-md-5 col-lg-4">
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'rural.png'); ?>" alt="Rural" class="ad2-1 img-fluid current-cms-img" data-cms-key="ads3" style="width:100%; max-width: 400px;">
      </div>
      <div class="col-7 col-md-5 col-lg-4">
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'greenhouse.png'); ?>" alt="Greenhouse" class="ad2-2 img-fluid" style="width:100%; max-width: 400px;">
      </div>
    </div>
    
   <!-- EDIT BUTTON -->
<div class="text-center mb-3">
  <?php if (isset($_SESSION['user_id'])): ?>
    <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-2 py-2 mt-2 mb-2" style="border-color: black;" onclick="toggleEditAll(this)" data-modal-target=".edit-ads-mv">
      Change Advertisements
    </button>
  <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade edit-ads-mv" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Advertisements Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-4">
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">

          <!-- First Advertisement -->
          <div class="text-center">
            <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'rural.png'); ?>" 
                 alt="Advertisement 3" 
                 class="img-fluid mb-2 current-cms-img" 
                 data-cms-key="ads3" 
                 style="max-width: 100%; height: auto;">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads3" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </div>

          <!-- Second Advertisement -->
          <div class="text-center">
            <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'greenhouse.png'); ?>" 
                 alt="Advertisement 4" 
                 class="img-fluid mb-2 current-cms-img" 
                 data-cms-key="ads4" 
                 style="max-width: 100%; height: auto;">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads4" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </div>

        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</section>