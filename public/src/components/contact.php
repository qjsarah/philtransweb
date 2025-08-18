<?php
include 'backend/config.php'; // adjust path if needed

// Fetch background color from database
$keys = ['contact_title', 'email', 'number', 'location', 'location_img', 'contact_img', 'web_img'];

$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM contact WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();


$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}

$contactBg = '#000066'; // fallback default
$result = $conn->query("SELECT content FROM contact WHERE key_name = 'contact_bg'");
if ($result && $row = $result->fetch_assoc()) {
    $contactBg = $row['content'];
}
?>

<!-- Contact Section with Editable Background -->
<section class="contactbg contact text-center text-white" style="background-color: <?= htmlspecialchars($contactBg) ?>;">
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="text-center mb-5">
        <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".contactContent">Edit</button>
        <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-contact-image">Edit Image</button>
    </div>
<?php endif; ?>
    <div class="container py-5">
        <h5 class="display-5 fw-bold"><?php echo htmlspecialchars($content['contact_title'] ?? "Get in Touch."); ?></h5>
        <p></p>

        <!-- Contact Form -->
        <div class="row justify-content-center">
            <form class="col-md-8 mt-4">
                <div class="form-group row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <input type="text" class="form-control" id="inputName" placeholder="Enter your name">
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email">
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-12">
                        <textarea class="form-control" id="inputMessage" rows="7" placeholder="Type your message here..."></textarea>
                    </div>
                </div>

                <div class="col text-end">
                    <button type="submit" class="contact_button px-3 py-2 rounded text-white">Send Message</button>
                </div>
            </form>
        </div>
    </div> 

    <!-- Contact Info Section -->
    <div class="d-flex w-75 flex-column flex-md-row text-center justify-content-md-between mx-auto">
        <div class="iconleft py-4">
            <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message.png')?>" class="icon-img current-cms-img" alt="Mail Icon" data-cms-key="contact_img">
            </div>
            <div class="contact_nav d-flex flex-column">
                <a href=""><?php echo htmlspecialchars($content['email'] ?? "info@philtransinc.com"); ?></a>
                <a href=""><?php echo htmlspecialchars($content['number'] ?? "+63 917 501 0018"); ?></a>
            </div>
        </div>

        <div class="iconcen py-4 text-center">
            <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="icon-img current-cms-img" alt="Location Icon" data-cms-key="location_img">
            </div>
            <p class="w-50 w-md-50 mx-auto">
                <?php echo htmlspecialchars($content['location'] ?? "D-3 2F Plaza Victoria, Santo Rosario St., Sto Domingo, Angeles City 2009 Pampanga Philippines"); ?>
            </p>
        </div>

        <div class="iconright py-4">
            <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="icon-img current-cms-img" alt="Web Icon" data-cms-key="web_img">
            </div>
            <div class="contact_nav d-flex flex-column">
                <a href="#about">About us</a>
                <a href="">Copyright</a>
                <a href="">Privacy Policy</a>
                <a href="">Terms and Condition</a>
                <a href="">FAQs</a>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<!-- Content Edit Modal -->
<div class="modal fade contactContent" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Contact Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body">
        <!-- Background Color Editor (only visible if logged in) -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="POST" action="backend/savecms.php" class="mb-4 d-flex justify-content-center align-items-center gap-2">
                    <label for="contact_bg" class="form-label mb-0">Background Color:</label>
                    <input type="color" id="contact_bg" name="contact_bg" value="<?= htmlspecialchars($contactBg) ?>" class="form-control form-control-color" style="width: 60px; height: 40px;">
                    <button type="submit" class="btn btn-light btn-sm">Save</button>
                </form>
            <?php endif; ?>
        <form id="contact-content-form" method="POST" action="backend/savecms.php">
          <!-- Contact Title -->
          <label class="fw-bold">Contact Title</label>
          <textarea name="contact_title" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['contact_title'] ?? 'Get in Touch.'); ?></textarea>

          <!-- Email -->
          <label class="fw-bold">Email</label>
          <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($content['email'] ?? 'info@philtransinc.com'); ?>">

          <!-- Number -->
          <label class="fw-bold">Phone Number</label>
          <input type="text" name="number" class="form-control mb-3" value="<?php echo htmlspecialchars($content['number'] ?? '+63 917 501 0018'); ?>">

          <!-- Location -->
          <label class="fw-bold">Location</label>
          <textarea name="location" class="form-control mb-3" rows="3"><?php echo htmlspecialchars($content['location'] ?? 'Your location address here...'); ?></textarea>
          <div class="modal-footer">
            <button type="button" form="contact-content-form" class="save-button btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Image Edit Modal -->
<div class="modal fade edit-contact-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Contact Images</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-image-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
          <div class="row g-4">
            <!-- Contact Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Contact Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="contact_img" name="contact_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Web Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Web Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="web_img" name="web_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Location Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Location Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="location_img" name="location_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
