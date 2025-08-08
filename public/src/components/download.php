<?php
include 'backend/config.php'; // Ensure the path is correct

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'person1'];
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

<!-- Download Section -->
<section class="downloadbg">
   
  <div class="d-flex justify-content-center align-items-start text-center text-md-start flex-column flex-lg-row downloadbg">

  <!-- Text & Buttons Column -->
  <div class="mb-4 mb-md-0 px-5">
    <!-- DISPLAY -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Edit Button -->
      <div class="text-start mb-3 h1main">
       <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".editContentModal">Edit</button>
      </div>
      <div id="download1-display">
        <h1 class="h1main fw-bold text-white mb-3 display-3">
          <?php echo htmlspecialchars($content['download1']  ?? 'DOWNLOAD OUR APP NOW!'); ?>
        </h1>
        <div id="paragraph1-display">
          <p class="desktop textstyle text-white mb-1 fs-4">
            <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before. "); ?>
          </p>
        </div>
      </div>

      <!-- DOWNLOAD1 FORM -->
      <div class="modal fade editContentModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="download1-form" method="POST" action="backend/savecms.php">
                <textarea name="download1" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['download1']??'DOWNLOAD OUR APP NOW!'); ?></textarea>
                <textarea name="paragraph1" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph1']??"Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before. "); ?></textarea>
                <div class="mt-5 me-5 w-100 mx-auto">
                  <img src="../main/images/download_section/<?php echo htmlspecialchars($content['person1'] ?? 'intro_img.png')?>" alt="Person" class="img-fluid current-cms-img" data-cms-key="person1">

                  <?php if (isset($_SESSION['user_id'])): ?>
                      <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="person1" accept="image/*">
                  <?php endif; ?>
                </div>
                <div id="edit-buttons" class="text-center modal-footer">
                  <button type="button" id="save-button" class="btn btn-success mb-2">Save</button>
                  <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <?php else: ?>
      <h1 class="h1main fw-bold text-white mb-3 display-3">
        <?php echo htmlspecialchars($content['download1'] ??'DOWNLOAD OUR APP NOW!'); ?>
      </h1>
      <p class="desktop textstyle text-white mb-4 fs-4">
        <?php echo htmlspecialchars($content['paragraph1']??"Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before. "); ?>
      </p>
    <?php endif; ?>

      <!-- Download Icons -->
      <div class="icons d-flex gap-5 flex-md-row flex-sm-row flex-lg-row flex-column justify-content-center justify-content-md-center justify-content-lg-start">
        <img src="../../public/main/images/download_section/apple.png" class="img-fluid mx-auto mx-lg-0" alt="Google Play" style="max-width: 200px;">
        <img src="../../public/main/images/download_section/google.png" class="img-fluid mx-auto mx-lg-0" alt="App Store" style="max-width: 200px;">
      </div>
    </div>

    <!-- Image Column -->
    <div class="person1 text-center mt-5 me-5 w-100 mx-auto">
      <img src="../main/images/download_section/<?php echo htmlspecialchars($content['person1'] ?? 'intro_img.png')?>" 
      alt="Person" class="img-fluid current-cms-img" data-cms-key="person1">
    </div>

    

    <!-- Mobile Text -->
    <p class="mobile textstyle text-white mb-4 fs-4 w-75 mx-auto">
      Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before.
    </p>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const saveButton = document.getElementById('save-button');
    const form = document.getElementById('download1-form');

    saveButton.addEventListener('click', function () {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to save this information?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
</script>

