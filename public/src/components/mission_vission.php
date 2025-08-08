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
        <div class="col-md-5 text-center d-none d-lg-block">
          <!-- CMS Image -->
          <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png')?>"
            alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
            data-cms-key="mission_image">
        </div>

        <!-- Text and Content -->
        <div class="col-12 col-lg-7 text-start">
          <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['mission'] ?? "MISSION"); ?></h1>
          <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph5'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income. By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience. Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?></p>
        </div>
     </div>

    <div class="vision row align-items-center flex-lg-row-reverse mt-5">
      <div class="col-md-5 text-center mb-md-0 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>"
            alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
            data-cms-key="vision_image">
      </div>
      <div class="col-12 col-lg-7 text-end">
        <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['vision'] ?? "VISION"); ?></h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph6'] ?? "In a future powered by our app, tricycle rides becomeeffortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service. We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income). Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being. This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?></p>
      </div>
    </div>

      <div class="text-center mb-5">
        <button type="button" class="btn btn-warning mt-3 mb-4" onclick="toggleEditAll(this)" data-modal-target=".mvContent">Edit</button>
      </div>
    </div>

    <!-- Edit Form -->
    <div class="modal fade mvContent" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Edit Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="mv-form" method="POST" action="backend/savecms.php">
              <textarea name="mission" class="form-control mb-3" rows="1"><?php echo htmlspecialchars($content['mission'] ?? "MISSION"); ?></textarea>
              <textarea name="paragraph5" class="form-control mb-3" rows="6"><?php echo htmlspecialchars($content['paragraph5'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income. By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience. Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?></textarea>
              <textarea name="vision" class="form-control mb-3" rows="1"><?php echo htmlspecialchars($content['vision'] ?? "VISION"); ?></textarea>
              <textarea name="paragraph6" class="form-control mb-3" rows="6"><?php echo htmlspecialchars($content['paragraph6'] ?? "In a future powered by our app, tricycle rides becomeeffortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service. We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income). Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being. This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?></textarea>
              <div class="d-flex justify-content-between align-items-center">
                <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png')?>" alt="Mission Image" class="img-fluid current-cms-img col-md-6 mx-auto" style="max-width: 250px;" data-cms-key="mission_image">
                <input type="file" class="form-control mt-3 cms-image-input" data-cms-key="mission_image" accept="image/*" style="max-width: 350px; margin: 0 auto;">
              </div>
              <div class="d-flex justify-content-center align-items-center">
                <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>" alt="Mission Image" class="img-fluid current-cms-img col-md-6 mx-auto" style="max-width: 250px;" data-cms-key="vision_image">
                <input type="file" class="form-control mt-3 cms-image-input" data-cms-key="vision_image" accept="image/*" style="max-width: 350px; margin: 0 auto;">
              </div>
              <div id="edit-buttons" class="text-center modal-footer">
                  <button type="submit" id="save_buton" class="btn btn-success mb-2">Save</button>
                  <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    

  <?php else: ?>

    <!-- MISSION Section -->
    <div class="mission row align-items-center">
      <div class="col-md-5 text-center mb-5 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png')?>"
      alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
      data-cms-key="mission_image">
      </div>
      <div class="col-12 col-lg-7 text-start">
        <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['mission'] ?? "MISSION"); ?></h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph5'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income. By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience. Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?></p>
      </div>
    </div>

    <!-- VISION Section -->
    <div class="vision row align-items-center flex-lg-row-reverse mt-5 mb-5">
      <div class="col-md-5 text-center mb-5 mb-md-0 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>"
              alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
              data-cms-key="vision_image">
      </div>
      <div class="col-12 col-lg-7 text-end">
        <h1 class="text-danger fw-bold display-4"><?php echo htmlspecialchars($content['vision'] ?? "VISION"); ?></h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['paragraph6']?? "In a future powered by our app, tricycle rides becomeeffortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service. We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income). Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being. This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?></p>
      </div>
    </div>

  <?php endif; ?>
</section>
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
              <div id="edit-buttons" class="text-center modal-footer">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('save_buton'); 
    const form = document.getElementById('mv-form');      

    if (saveBtn && form) {
      saveBtn.addEventListener('click', function (e) {
        e.preventDefault(); 

        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to save this?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#198754',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Save'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    }
  });
</script>
