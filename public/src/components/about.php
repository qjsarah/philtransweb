<?php
include 'backend/config.php';

// Keys to fetch from `aboutus` table
$keys = ['aboutus', 'PTAS', 'paragraph4', 'tricycle', 'aboutus_bgcolor'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM aboutus WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}

$bgColor = htmlspecialchars($content['aboutus_bgcolor'] ?? '#BF0D3D');
?>

<section class="text-white my-5" style="background-color: <?= $bgColor ?>; height: auto;">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="d-flex flex-column flex-lg-row w-100 justify-content-between py-5 container">
      <div class="col-lg-6 about-left">
        <h1 class="fw-bold display-5"><?= htmlspecialchars($content['aboutus'] ?? "ABOUT US"); ?></h1>
        <h2 class="fw-semibold mb-3 mt-4"><?= htmlspecialchars($content['PTAS'] ?? "PTAS: REVOLUTIONIZING RIDES..."); ?></h2>
        <p class="fs-5"><?= htmlspecialchars($content['paragraph4'] ?? "..."); ?></p>
      </div>
      <div class="about-right col-lg-6 text-center mt-5">
        <img src="../main/images/about_section/<?= htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png') ?>" class="img-fluid w-75 current-cms-img">
      </div>
    </div>
    <div class="text-center">
      <button type="button" class="btn btn-warning mb-5" data-bs-toggle="modal" data-bs-target="#aboutusModal">Edit</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="aboutusModal" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Edit Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="px-4">
              <label for="aboutus_bgcolor" class="form-label mt-3">Background Color</label>
              <input type="color" class="form-control form-control-color mb-3" id="aboutus_bgcolor" name="aboutus_bgcolor" value="<?= htmlspecialchars($content['aboutus_bgcolor'] ?? '#BF0D3D'); ?>">
          </div>
            <form id="aboutus-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
              <textarea name="aboutus" class="form-control mb-3" rows="2"><?= htmlspecialchars($content['aboutus'] ?? "ABOUT US"); ?></textarea>
              <textarea name="PTAS" class="form-control mb-3" rows="2"><?= htmlspecialchars($content['PTAS'] ?? "PTAS:..."); ?></textarea>
              <textarea name="paragraph4" class="form-control mb-3" rows="5"><?= htmlspecialchars($content['paragraph4'] ?? "..."); ?></textarea>



              <div class="col-lg-6 text-center mt-5">
                <img src="../main/images/about_section/<?= htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png') ?>" class="img-fluid w-75 current-cms-img">
              </div>

              <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="tricycle" name="tricycle_image" accept="image/*">

              <div class="modal-footer text-center">
                <button type="submit" class="btn btn-success mb-2">Save</button>
                <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Visitor View -->
    <div class="d-flex flex-column flex-lg-row w-100 justify-content-between py-5 container">
      <div class="col-lg-6 about-left">
        <h1 class="fw-bold display-5"><?= htmlspecialchars($content['aboutus'] ?? "ABOUT US"); ?></h1>
        <h2 class="fw-semibold mb-3 mt-4"><?= htmlspecialchars($content['PTAS'] ?? "PTAS:..."); ?></h2>
        <p class="fs-5"><?= htmlspecialchars($content['paragraph4'] ?? "..."); ?></p>
      </div>
      <div class="about-right col-lg-6 text-center mt-5">
        <img src="../main/images/about_section/<?= htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png') ?>" class="img-fluid w-75 current-cms-img">
      </div>
    </div>
  <?php endif; ?>
</section>
