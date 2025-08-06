<?php
include 'backend/config.php';

$keys = ['mission', 'vision', 'paragraph5', 'paragraph6', 'mission_image', 'vision_image', 'ads3', 'ads4'];
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

<!-- MISSION + VISION -->
<section class="container text-black mt-md-5 mt-lg-0">

  <?php if (isset($_SESSION['user_id'])): ?>
    <!-- View Mode (Logged In) -->
    <div id="mv-view">
      <div class="mission d-flex align-items-start gap-3">
  <div class="col-md-5 text-center mb-5 d-none d-lg-block">
    <!-- CMS Image -->
    <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png')?>"
      alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
      data-cms-key="mission_image">

    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- File input directly under image -->
      <input type="file"
             class="form-control mt-3 cms-image-input"
             data-cms-key="mission_image" accept="image/*"
             style="max-width: 350px; margin: 0 auto;">
    <?php endif; ?>
  </div>

  <!-- Text and Content -->
  <div class="col-12 col-lg-7 text-start">
    <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['mission']); ?></h1>
    <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph5']); ?></p>
  </div>
</div>


      <div class="vision row align-items-center flex-lg-row-reverse mt-5 mb-5">
        <div class="col-md-5 text-center mb-5 mb-md-0 d-none d-lg-block">
          <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>"
              alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
              data-cms-key="vision_image">

            <?php if (isset($_SESSION['user_id'])): ?>
              <!-- File input directly under the image -->
              <input type="file"
                    class="form-control mt-3 cms-image-input"
                    data-cms-key="vision_image" accept="image/*"
                    style="max-width: 350px; margin: 0 auto;">
            <?php endif; ?>
        </div>
        <div class="col-12 col-lg-7 text-end">
          <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['vision']); ?></h1>
          <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph6']); ?></p>
        </div>
      </div>

      <div class="text-center">
        <button type="button" class="btn btn-warning mt-3 mb-4" onclick="toggleEditMV()">Edit</button>
      </div>
    </div>

    <!-- Edit Form -->
    <form id="mv-form" method="POST" action="backend/savecms.php" style="display: none;">
      <textarea name="mission" class="form-control mb-3" rows="1"><?php echo htmlspecialchars($content['mission']); ?></textarea>
      <textarea name="paragraph5" class="form-control mb-3" rows="3"><?php echo htmlspecialchars($content['paragraph5']); ?></textarea>
      <textarea name="vision" class="form-control mb-3" rows="1"><?php echo htmlspecialchars($content['vision']); ?></textarea>
      <textarea name="paragraph6" class="form-control mb-3" rows="3"><?php echo htmlspecialchars($content['paragraph6']); ?></textarea>

      <div id="mv-edit-buttons" class="text-center">
        <button type="submit" form="mv-form" class="btn btn-success mb-2">Save Changes</button>
        <button type="button" class="btn btn-secondary mb-2 ms-2" onclick="toggleEditMV()">Cancel</button>
      </div>
    </form>

  <?php else: ?>
    <!-- Guest View (Fixed with Layout + Images) -->

    <!-- MISSION Section -->
    <div class="mission row align-items-center">
      <div class="col-md-5 text-center mb-5 d-none d-lg-block">
        <img src="../../public/main/images/mission_and_vission_section/mission.png" alt="Mission Image" class="img-fluid" style="max-width: 350px;">
      </div>
      <div class="col-12 col-lg-7 text-start">
        <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['mission']); ?></h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph5']); ?></p>
      </div>
    </div>

    <!-- VISION Section -->
    <div class="vision row align-items-center flex-lg-row-reverse mt-5 mb-5">
      <div class="col-md-5 text-center mb-5 mb-md-0 d-none d-lg-block">
        <img src="../../public/main/images/mission_and_vission_section/vision.png" alt="Vision Image" class="img-fluid" style="max-width: 350px;">
      </div>
      <div class="col-12 col-lg-7 text-end">
        <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['vision']); ?></h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph6']); ?></p>
      </div>
    </div>

  <?php endif; ?>

  <!-- Ads -->
  <div class="row justify-content-center align-items-center gap-3 pb-5">
    <div class="col-7 col-md-5 col-lg-4 text-center">
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'ads.jpg'); ?>" alt="Rural" class="ad2-1 img-fluid current-cms-img" data-cms-key="ads3" style="width:100%; max-width: 400px;">
      <?php if (isset($_SESSION['user_id'])): ?>
          <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads3" accept="image/*">
        <?php endif; ?>
    </div>
    
    <div class="col-7 col-md-5 col-lg-4 text-center">
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'ads.jpg'); ?>" alt="Greenhouse" class="ad2-2 img-fluid" style="width:100%; max-width: 400px;">
      <?php if (isset($_SESSION['user_id'])): ?>
          <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads4" accept="image/*">
        <?php endif; ?>
    </div>
  </div>
</section>
