<?php
include 'backend/config.php';

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'phone_image'];
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
<section class="welcome mt-5 container">
    <div class="mt-5 pt-5 d-flex flex-column flex-lg-row justify-content-start gap-5 mx-3">
        <div class="col-md-6 mx-auto">
            <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone_image'] ?? 'welcome_img.png')?>" class="phone1 current-cms-img img-fluid" data-cms-key="phone_image" alt="welcome image">
            <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-3 py-2 mt-2 d-block mx-auto " style="border-color: black;"  onclick="toggleEditAll(this)" data-modal-target=".edit-welcome-image">Change Image</button>      
        </div>
        <div class="my-5 text-danger fs-5">

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Display Section -->
            <div id="all-display">
                <h4 class="fw-bold display-5"><?php echo htmlspecialchars($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?></h4>
                <p class="textstyle text-danger mb-4 fs-4"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?></p>

                <p class="textstyle text-danger mb-4 fs-4"><?php echo htmlspecialchars($content['paragraph3'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?></p>
                <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-3 py-2 mt-2 " style="border-color: black;"onclick="toggleEditAll(this)" data-modal-target=".welcomeContent">Edit Content</button>
            </div>

           <!-- Welcome Content Modal -->
<div class="modal fade welcomeContent" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header px-4 border-bottom-0">
        <h3 class="modal-title fw-bold">Edit Welcome Section</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <hr>
        <form method="POST" action="backend/savecms.php" class="form">
          
          <!-- Welcome Title -->
          <label for="welcome" class="form-label fw-bold text-secondary">Welcome Title:</label>
          <textarea name="welcome" class="form-control mb-3 rounded-1 p-2" rows="2" style="border-color: black;"><?php echo htmlspecialchars($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?></textarea>

          <!-- Paragraph 1 -->
          <label for="paragraph2" class="form-label fw-bold text-secondary mt-2">Paragraph 1:</label>
          <textarea name="paragraph2" class="form-control mb-3 rounded-1 p-2" rows="4" style="border-color: black;"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?></textarea>

          <!-- Paragraph 2 -->
          <label for="paragraph3" class="form-label fw-bold text-secondary mt-2">Paragraph 2:</label>
          <textarea name="paragraph3" class="form-control mb-3 rounded-1 p-2" rows="4" style="border-color: black;"><?php echo htmlspecialchars($content['paragraph3'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?></textarea>

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


            <!-- Welcome Image Edit Modal -->
            <div class="modal fade edit-welcome-image" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                    <div class="modal-header px-4 border-bottom-0">
                        <h3 class="modal-title fw-bold text-dark">Welcome Image Content</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <hr>
                        <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="form">
                        <div class="d-flex justify-content-center">
                            <div class="me-5 w-75 text-center">
                            <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone_image'] ?? 'welcome_img.png')?>" 
                                alt="Welcome Image" 
                                class="img-fluid current-cms-img w-50 mb-2" 
                                data-cms-key="phone_image">
                            <div class="upload-box uploadBox">
                                <input type="file" 
                                    class="form-control cms-image-input fileInput mx-auto" 
                                    data-cms-key="phone_image" 
                                    name="phone_image" 
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
        <!-- Public Display Content -->
            <h4 class="fw-bold display-5 text-danger"><?php echo htmlspecialchars($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?></h4>
            <p class="textstyle text-danger mb-4 fs-4"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well.");  ?></p>
            <p class="textstyle text-danger mb-4 fs-4"><?php echo htmlspecialchars($content['paragraph3'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs." ); ?></p>
        <?php endif; ?>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>