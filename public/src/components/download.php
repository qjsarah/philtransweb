<?php
include 'backend/config.php'; // Ensure the path is correct

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'person1', 'download_bg_color', 'download_title_color','download_desc_color'];
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
<section class="pt-5 pb-5 h-auto downloadbg d-flex justify-content-center align-items-start text-center text-md-start flex-column flex-lg-row" style="background-color: <?php echo htmlspecialchars($content['download_bg_color'] ?? '#BF0D3D'); ?>;">

  <!-- Text & Buttons Column -->
  <div class="mb-4 mb-md-0 px-5">
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Edit Button -->
      <!-- Display Content -->
      <div id="download1-display">
        <h1 class="h1main fw-bold mb-3 display-3"
    style="color: <?php echo htmlspecialchars($content['download_title_color'] ?? '#FFFFFF'); ?>;">
    <?php echo htmlspecialchars($content['download1']  ?? 'DOWNLOAD OUR APP NOW!'); ?>
</h1>

        <div id="paragraph1-display">
          <p class="desktop textstyle mb-1 fs-4" style="color: <?php echo htmlspecialchars($content['download_desc_color'] ?? '#FFFFFF'); ?>;">
            <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today and experience transportation like never before."); ?>
          </p>
        </div>
      </div>
      <div class="text-start my-3 h1main">
        <button type="button" class="contact_button w-auto px-3 py-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".editContentModal">Edit Content</button>
      </div>

      <!-- Modal Form -->
      <div class="modal fade editContentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header px-4 border-bottom-0">
              <h3 class="modal-title fw-bold">Download Section Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
              <hr>
              <form method="POST" id="downloadForm" action="backend/savecms.php" enctype="multipart/form-data" class="form">
                <!-- Responsive flex container: stacks vertically on mobile -->
                    <label for="download_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
                     <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                      <input type="text" 
                            id="download_bg_hex" 
                            class="form-control text-uppercase mb-1 mb-md-0" 
                            maxlength="10" 
                            style="border-color: black; flex: 0 0 27%;" 
                            value="<?php echo htmlspecialchars($content['download_bg_color'] ?? '#1a1a1a'); ?>">
                      <input type="color" 
                            class="form-control form-control-color w-100 w-md-auto" 
                            id="download_bg_color" 
                            name="download_bg_color" 
                            style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"  
                            value="<?php echo htmlspecialchars($content['download_bg_color'] ?? '#1a1a1a'); ?>">
                    </div>



                <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                  <!-- Color Picker Container -->
                  <div style="min-width: 200px; width: 100%; max-width: 200px;">
                  
                    <label for="download_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
                    <input type="text" 
                          id="download_title_hex" 
                          name="download_title_color"  
                          class="form-control text-uppercase mb-2" 
                          maxlength="10" 
                          style="border-color: black; " 
                          value="<?php echo htmlspecialchars($content['download_title_color'] ?? '#1a1a1a'); ?>">

                    <input type="color" 
                          class="form-control form-control-color mb-2" 
                          id="download_title_color" 
                          style="height: 44px; padding: 5px; border-color: black; width: 100%;"  
                          value="<?php echo htmlspecialchars($content['download_title_color'] ?? '#1a1a1a'); ?>">

                    <label for="download_desc_color" class="form-label fw-bold text-secondary mt-3">Description Font Color:</label>
                    <input type="text" 
                          id="download_desc_hex" 
                          name="download_desc_color"  
                          class="form-control text-uppercase mb-2" 
                          maxlength="10" 
                          style="border-color: black; width: 100%;" 
                          value="<?php echo htmlspecialchars($content['download_desc_color'] ?? '#1a1a1a'); ?>">

                    <input type="color" 
                          class="form-control form-control-color mb-2" 
                          id="download_desc_color" 
                          style="height: 68px; padding: 5px; border-color: black; width: 100%;"  
                          value="<?php echo htmlspecialchars($content['download_desc_color'] ?? '#1a1a1a'); ?>">
                  </div>

                  <!-- Textarea -->
                  <div class="flex-grow-1 w-100">
                    <label for="download1" class="form-label fw-bold text-secondary">Title:</label>
                    <textarea name="download1" 
                              class="form-control rounded-1 p-2" 
                              rows="3" 
                              style="border-color: black; width: 100%;"><?php echo htmlspecialchars($content['download1'] ?? 'DOWNLOAD OUR APP NOW!'); ?></textarea>

                    <label for="paragraph1" class="form-label fw-bold text-secondary pt-2 mt-3">Description:</label>
                    <textarea name="paragraph1" 
                              class="mb-3 rounded-1 p-2" 
                              rows="4" 
                              style="border-color: black; width: 100%;"><?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today..."); ?></textarea>
                  </div>
                </div>
                <hr>
                <div class="text-center modal-footer d-flex flex-column flex-md-row justify-content-center gap-3">
                  <button type="submit" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
                  <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

          <!-- Image Edit Modal -->
        <div class="modal fade edit-download-iamge" tabindex="-1">
          <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
              <div class="modal-header px-4 border-bottom-0">
                <h3 class="modal-title fw-bold text-dark">Download Image Content</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body px-4">
                <hr>
                <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="form">
                  <div class="d-flex justify-content-center">
                    <div class="me-5 w-75 text-center">
                      <img src="../main/images/download_section/<?php echo htmlspecialchars($content['person1'] ?? 'intro_img.png')?>" 
                          alt="Person" 
                          class="img-fluid current-cms-img w-50 mb-2" 
                          data-cms-key="person1">
                          <div class="upload-box uploadBox">
                            <input type="file" 
                            class="form-control cms-image-input fileInput mx-auto " 
                            data-cms-key="person1" 
                            name="person1" 
                            accept="image/*" 
                            style="max-width: 300px;">
                            <p>Click or drag a file here to upload</p>
                          </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

    <?php else: ?>
      <!-- Public View -->
     <h1 class="h1main fw-bold display-3 pt-3 text-center text-lg-start"
    style="color: <?php echo htmlspecialchars($content['download_title_color'] ?? '#FFFFFF'); ?>;">
    <?php echo htmlspecialchars($content['download1'] ?? 'DOWNLOAD OUR APP NOW!'); ?>
</h1>

     <p class="desktop textstyle mb-4 fs-4 text-center text-lg-start" style="color: <?php echo htmlspecialchars($content['download_desc_color'] ?? '#FFFFFF'); ?>;">
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
    <?php if (isset($_SESSION['user_id'])): ?>
      <button type="button" class="contact_button w-50 px-3 py-2 mt-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".edit-download-iamge">Change Image</button>
    <?php endif ?>
  </div>

  <!-- Mobile Text -->
  <p class="mobile textstyle mb-4 mx-2 fs-4 text-center text-lg-start" style="color: <?php echo htmlspecialchars($content['download_desc_color'] ?? '#FFFFFF'); ?>;">
        <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today..."); ?>
      </p>
    
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // BG
    const bgColorPicker = document.getElementById("download_bg_color");
    const bgHexInput    = document.getElementById("download_bg_hex");

    // Title color
    const titleColorPicker = document.getElementById("download_title_color");
    const titleHexInput    = document.getElementById("download_title_hex");

    // Description color
    const descColorPicker = document.getElementById("download_desc_color");
    const descHexInput    = document.getElementById("download_desc_hex");

    // Elements to preview live
    const titleElement = document.querySelector(".h1main");
    const descElement  = document.querySelector("#paragraph1-display p");
    const sectionElement = document.querySelector("section.downloadbg");

    const form = document.getElementById("downloadForm");

    // Store original values from PHP content when page loads
    const original = {
      bgColor: '<?php echo addslashes($content['download_bg_color'] ?? '#BF0D3D'); ?>',
      titleColor: '<?php echo addslashes($content['download_title_color'] ?? '#FFFFFF'); ?>',
      descColor: '<?php echo addslashes($content['download_desc_color'] ?? '#FFFFFF'); ?>',
      titleText: '<?php echo addslashes($content['download1'] ?? 'DOWNLOAD OUR APP NOW!'); ?>',
      descText: '<?php echo addslashes($content['paragraph1'] ?? 'Download the Philippine Trans App System today...'); ?>',
    };

    // Sync BG color picker with hex input and live preview
    bgColorPicker.addEventListener("input", function () {
        bgHexInput.value = this.value;
        sectionElement.style.backgroundColor = this.value;
    });
    bgHexInput.addEventListener("input", function () {
        bgColorPicker.value = this.value;
        sectionElement.style.backgroundColor = this.value;
    });

    // Title color live sync
    titleColorPicker.addEventListener("input", function () {
        titleHexInput.value = this.value;
        titleElement.style.color = this.value;
    });
    titleHexInput.addEventListener("input", function () {
        titleColorPicker.value = this.value;
        titleElement.style.color = this.value;
    });

    // Description color live sync
    descColorPicker.addEventListener("input", function () {
        descHexInput.value = this.value;
        descElement.style.color = this.value;
    });
    descHexInput.addEventListener("input", function () {
        descColorPicker.value = this.value;
        descElement.style.color = this.value;
    });

    // Ensure correct values are sent on submit
    form.addEventListener("submit", function () {
        bgColorPicker.value    = bgHexInput.value;
        titleColorPicker.value = titleHexInput.value;
        descColorPicker.value  = descHexInput.value;
    });

    // Reset preview to original values when modal is cancelled or closed without save
    const modal = document.querySelector(".editContentModal");
    const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");

    function resetPreview() {
      // Reset colors
      bgColorPicker.value = original.bgColor;
      bgHexInput.value = original.bgColor;
      titleColorPicker.value = original.titleColor;
      titleHexInput.value = original.titleColor;
      descColorPicker.value = original.descColor;
      descHexInput.value = original.descColor;

      // Reset live preview styles
      sectionElement.style.backgroundColor = original.bgColor;
      titleElement.style.color = original.titleColor;
      descElement.style.color = original.descColor;

      // Reset text contents
      titleElement.textContent = original.titleText;
      descElement.textContent = original.descText;

      // Reset textarea values in the form
      form.download1.value = original.titleText;
      form.paragraph1.value = original.descText;
    }

    // Reset when cancel button clicked
    cancelBtn.addEventListener("click", resetPreview);

    // Reset when modal is closed by other means (click outside or ESC)
    modal.addEventListener('hidden.bs.modal', resetPreview);
});
</script>
