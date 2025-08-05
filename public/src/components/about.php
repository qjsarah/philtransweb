<?php
include 'backend/config.php'; // Ensure the path is correct

// These are the CMS keys you want to fetch from the 'download' table
$keys = ['aboutus', 'PTAS', 'paragraph4'];

// Create placeholders for the prepared statement
$placeholders = implode(',', array_fill(0, count($keys), '?'));

// Prepare the statement
$sql = "SELECT key_name, content FROM aboutus WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);

// Bind the parameters (all strings)
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

// Map results into an associative array
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<section class="text-white my-5" style="background-color: #BF0D3D; height: auto; animation: fadeIn linear; animation-timeline: view(); animation-range: entry 0 cover 50%;">
  <!-- Desktop Layout: Image Right, Text Left -->
  <div class="container py-5 d-flex flex-column flex-lg-row w-100 justify-content-between">
      <div class="row align-items-center">
    <!-- Left Column (Text Content) -->
        <div class="about-left text-start w-100">
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Read-only content (visible when not editing) -->
            <div id="aboutus-view">
              <h1 class="fw-bold display-5"><?php echo htmlspecialchars($content['aboutus']); ?></h1>
              <h2 class="fw-semibold mb-3 mt-4"><?php echo htmlspecialchars($content['PTAS']); ?></h2>
              <p class="fs-5"><?php echo htmlspecialchars($content['paragraph4']); ?></p>
              <!-- Edit Button -->
              <div class="text-center">
                <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAboutUs()">Edit</button>
              </div>
            </div>

            <form id="aboutus-form" method="POST" action="backend/savecms.php" style="display: none;">
              <!-- Editable Fields -->
              <textarea name="aboutus" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['aboutus']); ?></textarea>
              <textarea name="PTAS" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['PTAS']); ?></textarea>
              <textarea name="paragraph4" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph4']); ?></textarea>

              <div id="aboutus-edit-buttons" class="text-center">
              <!-- SAVE BOTAN-->
                <button type="submit" form="aboutus-form" class="btn btn-success mb-2">Save Changes</button>
                <button type="button" class="btn btn-secondary mb-2 ms-2" onclick="toggleEditAboutUs()">Cancel</button>
              </div>
            </form>

          <?php else: ?>
            <h1 class="fw-bold display-5"><?php echo htmlspecialchars($content['aboutus']); ?></h1>
            <h2 class="fw-semibold mb-3 mt-4"><?php echo htmlspecialchars($content['PTAS']); ?></h2>
            <p class="textstyle text-white mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph4']); ?></p>
          <?php endif; ?>
        </div>
      </div>
      <!-- Right Column (Image) -->
      <div class="about-right col-lg-6 text-center mt-5">
        <img src="../../public/main/images/about_section/desktop_trycicle.png" alt="Tricycle" class="img-fluid w-75" >
      </div>
    </div>
  </div>

  <!-- Mobile & Tablet
  <div class="text-center py-4 d-lg-none">
    <img src="../../public/main/images/about_section/trycicle.png" alt="Tricycle" class="img-fluid w-75">
  </div>
  
  <div class="text-center d-lg-none">
    <h1 class="fw-bold display-3">ABOUT US</h1>
  </div>
  
  <div class="container py-3 d-lg-none">
    <div class="row">
      <div class="text-center">
        <h2 class="fw-semibold mb-3">
          PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY
        </h2>
        <p class="fs-5">
          In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. 
          It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered 
          around the very people who keep the tricycle industry moving – the drivers. PTAS transcends the mere 
          act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, 
          enhancing passenger experiences.
        </p>
      </div>
    </div>
  </div> -->
</section>