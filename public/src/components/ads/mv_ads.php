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
  <?php if (isset($_SESSION['user_id'])): ?>
  <!--DISPLAY-->
    <div class="text-center row justify-content-center align-items-center gap-3 pb-5">
      <div class="col-7 col-md-5 col-lg-4">
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'rural.png'); ?>" alt="Rural" class="ad2-1 img-fluid current-cms-img" data-cms-key="ads3" style="width:100%; max-width: 400px;">
      </div>
      <div class="col-7 col-md-5 col-lg-4">
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'greenhouse.png'); ?>" alt="Greenhouse" class="ad2-2 img-fluid" style="width:100%; max-width: 400px;">
      </div>
    </div>
    <!--EDIT BOTAN-->
    <div class="text-center mb-3">
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-ads-mv">Edit</button>
    </div>
    <div class="modal fade edit-ads-mv" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <?php if (isset($_SESSION['user_id'])): ?>
              <div  class="d-flex justify-content-center align-items-center">
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'rural.png'); ?>" alt="Rural" class="img-fluid current-cms-img col-md-6 mx-auto" data-cms-key="ads3" style="width:100%; max-width: 200px;">
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads3" accept="image/*">
              </div>
              <div class="d-flex justify-content-center align-items-center">
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'greenhouse.png'); ?>" alt="Rural" class="img-fluid current-cms-img col-md-6 mx-auto" data-cms-key="ad4" style="width:100%; max-width: 200px;">
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads4" accept="image/*">
              </div>
              <?php endif; ?>
              <div class="text-center modal-footer">
                <button type="submit" form="download1-form" class="btn btn-success mb-2">Save</button>
                <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="row justify-content-center align-items-center gap-3 pb-5">
        <div class="col-7 col-md-5 col-lg-4">
          <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'rural.png'); ?>" alt="Rural" class="ad2-1 img-fluid current-cms-img" data-cms-key="ads3" style="width:100%; max-width: 400px;">
        </div>
        <div class="col-7 col-md-5 col-lg-4">
          <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'greenhouse.png'); ?>" alt="Greenhouse" class="ad2-2 img-fluid" style="width:100%; max-width: 400px;">
        </div>
      </div>
    <?php endif; ?>

</section>