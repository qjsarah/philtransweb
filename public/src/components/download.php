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

      <!-- DOWNLOAD1 DISPLAY -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <div id="download1-display">
          <h1 class="h1main fw-bold text-white mb-3 display-3">
            <?php echo htmlspecialchars($content['download1']); ?>
          </h1>
        </div>

        <!-- DOWNLOAD1 FORM -->
        <form id="download1-form" method="POST" action="backend/savecms.php" style="display: none;">
          <textarea name="download1" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['download1']); ?></textarea>
          <!-- Buttons are shared and placed after both forms -->
        </form>
      <?php else: ?>
        <h1 class="h1main fw-bold text-white mb-3 display-3">
          <?php echo htmlspecialchars($content['download1']); ?>
        </h1>
      <?php endif; ?>

      <!-- PARAGRAPH1 DISPLAY -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <div id="paragraph1-display">
          <p class="desktop textstyle text-white mb-1 fs-3">
            <?php echo htmlspecialchars($content['paragraph1']); ?>
          </p>
        </div>

        <!-- PARAGRAPH1 FORM -->
        <form id="paragraph1-form" method="POST" action="backend/savecms.php" style="display: none;">
          <textarea name="paragraph1" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph1']); ?></textarea>
        </form>

        <!-- SHARED SAVE/CANCEL BUTTONS -->
        <div id="edit-buttons" class="text-center" style="display: none;">
          <button type="submit" form="download1-form" class="btn btn-success mb-2">Save Changes</button>
          <button type="submit" form="paragraph1-form" class="btn btn-success mb-2 ms-2">Save Paragraph</button>
          <button type="button" class="btn btn-secondary mb-2 ms-2" onclick="toggleEditAll()">Cancel</button>
        </div>

        <!-- Edit Button -->
        <div class="text-start mb-3">
          <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll()">Edit</button>
        </div>

      <?php else: ?>
        <p class="desktop textstyle text-white mb-4 fs-3">
          <?php echo htmlspecialchars($content['paragraph1']); ?>
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

      <?php if (isset($_SESSION['user_id'])): ?>
          <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="person1" accept="image/*">
      <?php endif; ?>
    </div>

    

    <!-- Mobile Text -->
    <p class="mobile textstyle text-white mb-4 fs-3 w-75 mx-auto">
      Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before.
    </p>
  </div>
</section>
<script>
 
</script>