<?php
include 'backend/config.php';

// Fetch ads5 and ads6 from DB
$result = $conn->query("SELECT key_name, content FROM services WHERE key_name IN ('ads5', 'ads6')");
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section class="py-4 mt-2">
    <div class="d-flex flex-column flex-xl-row justify-content-around gap-3">
        <!-- Ads 5 -->
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads5'] ?? 'ads_no_3.png'); ?>" class="ads3 img-fluid current-cms-img" alt="Ad Image" data-cms-key="ads5" style="max-width: 100%;">
        <!-- Ads 6 -->
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads6'] ?? 'ads_no_4.png'); ?>" class="ads3-2 img-fluid current-cms-img" alt="Ad Image" data-cms-key="ads6" style="max-width: 100%;">
    </div>
    <!-- EDIT BUTTON -->
    <div class="text-center mb-3 ad1">
  <?php if (isset($_SESSION['user_id'])): ?>
      <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-2 py-2 mt-3" 
          style="border-color: black;"  onclick="toggleEditAll(this)" data-modal-target=".edit-ads-5"> Change Advertisement</button>
  <?php endif; ?>
    </div>

    <!-- Modal -->
    <div class="modal fade edit-ads-5" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
          <div class="modal-header px-4 border-bottom-0">
            <h3 class="modal-title fw-bold text-dark">Edit Advertisements</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <?php if (isset($_SESSION['user_id'])): ?>
              <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3 mb-4">
                <!-- Ads 5 -->
                <div class="text-center">
                  <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads5'] ?? 'ads_no_3.png'); ?>" 
                       alt="Ad Image" 
                       class="img-fluid mb-2 current-cms-img" 
                       data-cms-key="ads5" 
                       style="max-width: 100%; height: auto;">
                  <div class="upload-box uploadBox">
                    <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads5" accept="image/*">
                    <p>Click or drag a file here to upload</p>
                  </div>
                </div>

                <!-- Ads 6 -->
                <div class="text-center">
                  <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads6'] ?? 'ads_no_4.png'); ?>" 
                       alt="Ad Image" 
                       class="img-fluid mb-2 current-cms-img" 
                       data-cms-key="ads6" 
                       style="max-width: 100%; height: auto;">
                  <div class="upload-box uploadBox">
                    <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads6" accept="image/*">
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
