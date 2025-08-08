<?php
include 'backend/config.php'; // Ensure the path is correct

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'person1', 'download_bg_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));

$sql = "SELECT key_name, content FROM download WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<!-- Blur Modal Backdrop -->
<style>
  .modal-backdrop.blur-backdrop {
    backdrop-filter: blur(8px);
    background-color: rgba(0, 0, 0, 0.3);
  }
</style>

<!-- Download Section -->
<section class="downloadbg d-flex justify-content-center align-items-start text-center text-md-start flex-column flex-lg-row" style="background-color: <?php echo htmlspecialchars($content['download_bg_color'] ?? '#BF0D3D'); ?>;">

  <!-- Text & Buttons Column -->
  <div class="mb-4 mb-md-0 px-5">
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Edit Button -->
      <div class="text-start mb-3 h1main">
        <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".editContentModal">Edit</button>
      </div>

      <!-- Display Content -->
      <div id="download1-display">
        <h1 class="h1main fw-bold text-white mb-3 display-3">
          <?php echo htmlspecialchars($content['download1']  ?? 'DOWNLOAD OUR APP NOW!'); ?>
        </h1>
        <div id="paragraph1-display">
          <p class="desktop textstyle text-white mb-1 fs-4">
            <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today and experience transportation like never before."); ?>
          </p>
        </div>
      </div>

      <!-- Modal Form -->
      <div class="modal fade editContentModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 1rem;">
            <div class="modal-header border-bottom-0">
              <h3 class="modal-title text-primary fw-bold">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="download1-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
                <textarea name="download1" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['download1']??'DOWNLOAD OUR APP NOW!'); ?></textarea>
                <textarea name="paragraph1" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph1']??"Download the Philippine Trans App System today..."); ?></textarea>

                <!-- Background Color Picker -->
                <label for="download_bg_color" class="form-label fw-bold text-secondary">Background Color</label>
                <input type="color" class="form-control form-control-color mb-3" id="download_bg_color" name="download_bg_color" value="<?php echo htmlspecialchars($content['download_bg_color'] ?? '#1a1a1a'); ?>">

                <!-- Image Upload -->
                <div class="me-5 w-50">
                  <img src="../main/images/download_section/<?php echo htmlspecialchars($content['person1'] ?? 'intro_img.png')?>" alt="Person" class="img-fluid current-cms-img w-50 mb-2" data-cms-key="person1">
                  <input type="file" class="form-control cms-image-input" name="person1" accept="image/*">
                </div>

                <!-- Submit Buttons -->
                <div id="edit-buttons" class="text-center modal-footer border-top-0">
                  <button type="submit" form="download1-form" class="btn btn-success mb-2">Save</button>
                  <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <?php else: ?>
      <!-- Public View -->
      <h1 class="h1main fw-bold text-white display-3 pt-3 text-center text-lg-start">
        <?php echo htmlspecialchars($content['download1'] ?? 'DOWNLOAD OUR APP NOW!'); ?>
      </h1>
      <p class="desktop textstyle text-white mb-4 fs-4 text-center text-lg-start">
        <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today..."); ?>
      </p>
    <?php endif; ?>

    <!-- Download Icons -->
    <div class="icons d-flex gap-lg-4 flex-md-row flex-sm-row flex-lg-row flex-column justify-content-center justify-content-md-center justify-content-lg-start">
      <img src="../../public/main/images/download_section/apple.png" class="img-fluid mx-auto my-2 mx-lg-0" alt="Apple Store" style="max-width: 200px;">
      <img src="../../public/main/images/download_section/google.png" class="img-fluid mx-auto my-2 mx-lg-0" alt="Google Play" style="max-width: 200px;">
    </div>
  </div>

  <!-- Right-side Image -->
  <div class="person1 text-center mt-1 py-5 me-5 w-100 mx-auto">
    <img src="../main/images/download_section/<?php echo htmlspecialchars($content['person1'] ?? 'intro_img.png')?>" alt="Person" class="img-fluid current-cms-img" data-cms-key="person1">
  </div>

  <!-- Mobile Text -->
  <p class="mobile textstyle text-white mb-4 fs-4 w-75 mx-auto">
    Download the Philippine Trans App System today and experience transportation like never before.
  </p>

</section>

<!-- Real-time color preview -->
<script>
  const colorPicker = document.getElementById("download_bg_color");
  if (colorPicker) {
    colorPicker.addEventListener("input", function () {
      document.querySelector("section.downloadbg").style.backgroundColor = this.value;
    });
  }
</script>

<!-- JavaScript to add blur class to modal backdrop -->
<script>
  const modal = document.querySelector('.editContentModal');
  if (modal) {
    modal.addEventListener('shown.bs.modal', function () {
      const backdrop = document.querySelector('.modal-backdrop');
      if (backdrop) {
        backdrop.classList.add('blur-backdrop');
      }
    });
  }
</script>
