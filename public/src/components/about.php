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

<section class="text-white my-5" style="background-color: <?= $bgColor ?>; height: auto; animation: fadeIn linear; animation-timeline: view(); animation-range: entry 0 cover 50%;">
            <!-- DISPLAY -->

          <?php if (isset($_SESSION['user_id'])): ?>
            
            <div class="d-flex flex-column flex-lg-row w-100 justify-content-between py-5 container">
              <div id="aboutus-view" class="col-lg-6 about-left">
                <h1 class="fw-bold display-5"><?php echo htmlspecialchars($content['aboutus'] ?? "ABOUT US"); ?></h1>
                <h2 class="fw-semibold mb-3 mt-4"><?php echo htmlspecialchars($content['PTAS'] ?? "PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY"); ?></h2>
                <p class="fs-5"><?php echo htmlspecialchars($content['paragraph4'] ?? "In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers. PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences."); ?></p>
                <div class="text-start">
                  <button type="button" class="btn btn-warning mb-5" onclick="toggleEditAll(this)" data-modal-target=".aboutContent">Edit</button>
                </div>
              </div>

              <div class="about-right col-lg-6 text-center mt-5   ">
                <img src="../main/images/about_section/<?php echo htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png')?>" alt="Tricycle" class="img-fluid w-75 current-cms-img" data-cms-key="tricycle" >
                <button type="button" class="btn btn-warning mb-5" onclick="toggleEditAll(this)" data-modal-target=".edit-about-image">Edit</button>
              </div>
            </div>
            <div class="modal fade aboutContent" tabindex="-1">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Edit Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form class="form" method="POST" action="backend/savecms.php">
                      
                      <!-- B ackground Color Picker -->
                      <label for="aboutus_bgcolor" class="form-label fw-bold text-secondary ">Background Color</label>
                      <input type="color" class="form-control form-control-color mb-3" id="aboutus_bgcolor" name="aboutus_bgcolor" value="<?php echo htmlspecialchars($content['aboutus_bgcolor'] ?? '#BF0D3D'); ?>">

                      <!-- Editable Fields -->
                      <textarea name="aboutus" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['aboutus'] ?? "ABOUT US"); ?></textarea>
                      <textarea name="PTAS" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['PTAS'] ?? "PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY"); ?></textarea>
                      <textarea name="paragraph4" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph4'] ?? "In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers. PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences."); ?></textarea>
                      <div class="text-center modal-footer">
                        <button type="button" class="btn btn-success mb-2 save-button">Save</button>
                        <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
      <div class="modal fade edit-about-image" tabindex="-1">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Edit Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form class="form" method="POST" action="backend/savecms.php">
                        <img src="../main/images/about_section/<?php echo htmlspecialchars($content['tricycle'] ?? 'trycicle.png')?>" alt="Tricycle" class="img-fluid w-75 current-cms-img" data-cms-key="tricycle" >
                        <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="tricycle" accept="image/*">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="d-flex flex-column flex-lg-row w-100 justify-content-between py-5 container">
              <div id="aboutus-view" class="col-lg-6 about-left">
                <h1 class="fw-bold display-5"><?php echo htmlspecialchars($content['aboutus']  ?? "ABOUT US"); ?></h1>
                <h2 class="fw-semibold  fs-4 mb-3 mt-4"><?php echo htmlspecialchars($content['PTAS'] ?? "PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY"); ?></h2>
                <p class="fs-5"><?php echo htmlspecialchars($content['paragraph4'] ?? "In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers. PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences."); ?></p>
              </div>

              <div class="about-right col-lg-6 text-center mt-5">
                <img src="../main/images/about_section/<?php echo htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png')?>" alt="Tricycle" class="img-fluid w-75 current-cms-img" data-cms-key="tricycle" >
              </div>
            </div>
          <?php endif; ?>

</section>  