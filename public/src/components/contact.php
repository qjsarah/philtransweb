<?php
include 'backend/config.php'; // adjust path if needed

// Fetch background color + title + font color from database
$keys = [
  'contact_title', 'email', 'number', 'location',
  'location_img', 'contact_img', 'web_img',
  'contact_bg', 'contact_title_color', 'contact_font_color'
];

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
?>


<!-- Contact Section -->
<section class="contactbg contact text-center"
  style="background-color: <?php echo htmlspecialchars($content['contact_bg'] ?? '#BF0D3D'); ?>;
         color: <?php echo htmlspecialchars($content['contact_font_color'] ?? '#FFFFFF'); ?>;">
<?php if (isset($_SESSION['user_id'])): ?>
  <div class="d-flex justify-content-center pt-3 gap-4">
    <button type="button" class="contact_button px-5 py-2 rounded text-white w-25 w-md-auto"
            onclick="toggleEditAll(this)" data-modal-target=".contactContent">Edit Content</button>
    <button type="button" class="contact_button px-5 py-2 rounded text-white w-25 w-md-auto"
            onclick="toggleEditAll(this)" data-modal-target=".edit-contact-image">Change Images</button>
  </div>
<?php endif; ?>

  <div class="container py-5">
    <!-- Contact Title with editable color -->
    <h5 class="display-5 fw-bold"
        style="color: <?php echo htmlspecialchars($content['contact_title_color'] ?? '#FFFFFF'); ?>;">
      <?php echo htmlspecialchars($content['contact_title'] ?? "Get in Touch."); ?>
    </h5>

    <!-- Contact Form -->
    <div class="row justify-content-center">
      <form class="col-md-8 mt-4" id="contactForm" method="POST" action="backend/savemessages.php">
        <div class="form-group row mb-3">
          <div class="col-md-6 mb-3 mb-md-0">
            <input type="text" class="form-control" name="name" placeholder="Enter your name">
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" name="email" placeholder="Enter your email">
          </div>
        </div>

        <div class="form-group row mb-4">
          <div class="col-12">
            <textarea class="form-control" rows="7" name="message" placeholder="Type your message here..."></textarea>
          </div>
        </div>

        <div class="col text-end">
          <button type="submit" class="contact_button px-3 py-2 rounded text-white">Send Message</button>
        </div>
      </form>
    </div>
  </div> 

  <!-- Contact Info -->
  <div class="d-flex w-75 flex-column flex-md-row text-center justify-content-md-between mx-auto">
    <div class="iconleft py-4">
      
      <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
        <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message.png')?>"
             class="icon-img current-cms-img" alt="Mail Icon" data-cms-key="contact_img">
      </div>
      <div class="contact_nav d-flex flex-column">
        <p href="mailto:<?php echo htmlspecialchars($content['email'] ?? 'info@philtransinc.com'); ?>" 
           class="text-decoration-none" >
          <?php echo htmlspecialchars($content['email'] ?? "info@philtransinc.com"); ?>
        </p>
        <p href="tel:<?php echo htmlspecialchars($content['number'] ?? '+639175010018'); ?>" 
           class="text-decoration-none">
          <?php echo htmlspecialchars($content['number'] ?? "+63 917 501 0018"); ?>
        </p>
      </div>
    </div>

    <div class="iconcen py-4 text-center">
      <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
        <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>"
             class="icon-img current-cms-img" alt="Location Icon" data-cms-key="location_img">
      </div>
      <p class="w-50 w-md-50 mx-auto">
        <?php echo htmlspecialchars($content['location'] ?? "D-3 2F Plaza Victoria, Santo Rosario St., Sto Domingo, Angeles City 2009 Pampanga Philippines"); ?>
      </p>
    </div>

    <div class="iconright py-4">
      <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
        <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>"
             class="icon-img current-cms-img" alt="Web Icon" data-cms-key="web_img">
      </div>
      <div class="contact_nav d-flex flex-column" >
        <a href="#about" class="text-decoration-none">About us</a>
        <a href="" class="text-decoration-none">Copyright</a>
        <a href="" class="text-decoration-none">Privacy Policy</a>
        <a href="" class="text-decoration-none">Terms and Condition</a>
        <a href="" class="text-decoration-none">FAQs</a>
      </div>
    </div>
  </div>
</section>

<!-- Content Edit Modal -->
<div class="modal fade contactContent" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      
      <div class="modal-header px-4 border-bottom-0">
        <h3 class="modal-title fw-bold">Edit Contact Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body px-4">
        <hr>
        <form id="contact-content-form" method="POST" action="backend/savecms.php">
          
          <!-- Background Color -->
          <label for="contact_bg" class="form-label fw-bold text-secondary">Background Color:</label>
          <div class="d-flex flex-column flex-md-row align-items-center gap-3 ">
            <input type="text" id="contact_bg_hex" name="contact_bg"  
                   class="form-control text-uppercase mb-1 mb-md-0" maxlength="10"
                   style="border-color: black; flex: 0 0 27%;"
                   value="<?php echo htmlspecialchars($content['contact_bg'] ?? '#1a1a1a'); ?>">
            <input type="color" class="form-control form-control-color w-100 w-md-auto "
                   id="contact_bg_picker"
                   style="height: 36px; padding: 5px; border-color: black; flex: 1 1 auto;"  
                   value="<?php echo htmlspecialchars($content['contact_bg'] ?? '#1a1a1a'); ?>">
          </div>

          <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
            <!-- Color Pickers -->
            <div style="min-width: 200px; width: 100%; max-width: 200px;">
              <!-- Title Color -->
              <label class="form-label fw-bold text-secondary">Title Color:</label>
              <input type="text" id="contact_title_hex" name="contact_title_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['contact_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="contact_title_picker" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['contact_title_color'] ?? '#FFFFFF'); ?>">

              <!-- Font Color -->
              <label class="form-label fw-bold text-secondary mt-3">Font Color:</label>
              <input type="text" id="contact_font_hex" name="contact_font_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['contact_font_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="contact_font_picker" class="form-control form-control-color mb-2" style="height: 38px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['contact_font_color'] ?? '#FFFFFF'); ?>">
            </div>

            <!-- Textareas -->
            <div class="flex-grow-1 w-100">
              <!-- Contact Title -->
              <label class="form-label fw-bold text-secondary">Contact Title:</label>
              <textarea name="contact_title" class="form-control mb-3 rounded-1 p-2" style="border-color: black;" rows="3"><?php echo htmlspecialchars($content['contact_title'] ?? 'Get in Touch.'); ?></textarea>

              <!-- Email -->
              <label class="form-label fw-bold text-secondary pt-2 ">Email:</label>
              <input type="email" name="email" class="form-control mb-3" style="border-color: black;" value="<?php echo htmlspecialchars($content['email'] ?? 'info@philtransinc.com'); ?>">

              <!-- Phone Number -->
              <label class="form-label fw-bold text-secondary pt-2 mt-3">Phone Number:</label>
              <input type="text" name="number" maxlength="13" class="form-control mb-3" style="border-color: black;" value="<?php echo htmlspecialchars($content['number'] ?? '+63 917 501 0018'); ?>">

              <!-- Location -->
              <label class="form-label fw-bold text-secondary pt-2 mt-3">Location:</label>
              <textarea name="location" class="form-control mb-3 rounded-1 p-2" style="border-color: black;" rows="3"><?php echo htmlspecialchars($content['location'] ?? 'Your location address here...'); ?></textarea>
            </div>
          </div>

          <hr>
          <div class="text-center modal-footer d-flex flex-column flex-md-row justify-content-center gap-3">
            <button type="button" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
            <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<!-- Image Edit Modal -->
<div class="modal fade edit-contact-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Change Contact Images:</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-image-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
          <div class="row g-4">
            <!-- Contact Icon -->
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold text-secondary pt-2 mt-3">Contact Icon:</label>
              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" 
                     class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="contact_img" name="contact_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Web Icon -->
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold text-secondary pt-2 mt-3">Web Icon:</label>
              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" 
                     class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="web_img" name="web_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Location Icon -->
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold text-secondary pt-2 mt-3">Location Icon:</label>
              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" 
                     class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
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

<script>
// Function to sync hex input and color picker with validation
function syncColorInputs(hexId, pickerId) {
  const hexInput = document.getElementById(hexId);
  const picker = document.getElementById(pickerId);

  if (!hexInput || !picker) return;

  // Hex → Picker
  hexInput.addEventListener("input", () => {
    let val = hexInput.value.trim();

    // Ensure starts with #
    if (!val.startsWith("#")) val = "#" + val;

    // Expand shorthand (#FFF → #FFFFFF)
    if (/^#([0-9A-Fa-f]{3})$/.test(val)) {
      val = "#" + val[1] + val[1] + val[2] + val[2] + val[3] + val[3];
    }

    // Validate 6-digit hex
    if (/^#([0-9A-Fa-f]{6})$/.test(val)) {
      picker.value = val.toUpperCase();
      hexInput.value = val.toUpperCase();
      picker.dispatchEvent(new Event("input")); // update preview
    }
  });

  // Picker → Hex
  picker.addEventListener("input", () => {
    hexInput.value = picker.value.toUpperCase();
  });
}

// Apply syncing for all color inputs
syncColorInputs("contact_bg_hex", "contact_bg_picker");
syncColorInputs("contact_title_hex", "contact_title_picker");
syncColorInputs("contact_font_hex", "contact_font_picker");

document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("contact-content-form");
  const contactSection = document.querySelector(".contactbg.contact");
  const titleEl = contactSection.querySelector("h5");
  const navLinks = contactSection.querySelectorAll(".contact_nav a, .contact_nav h5"); // include links & h5

  // Reset form when modal closes
  const contactModal = document.querySelector(".contactContent");
  if (contactModal && form) {
    contactModal.addEventListener("hidden.bs.modal", function () {
      form.reset();

      // restore all pickers from hex
      const bgHex = document.getElementById("contact_bg_hex");
      const bgPicker = document.getElementById("contact_bg_picker");
      const titleHex = document.getElementById("contact_title_hex");
      const titlePicker = document.getElementById("contact_title_picker");
      const fontHex = document.getElementById("contact_font_hex");
      const fontPicker = document.getElementById("contact_font_picker");

      if (bgHex && bgPicker) contactSection.style.backgroundColor = bgHex.value; 
      if (titleHex && titlePicker && titleEl) titleEl.style.color = titleHex.value; 
      if (fontHex && fontPicker) {
        contactSection.style.color = fontHex.value; 
        navLinks.forEach(el => el.style.color = fontHex.value); // apply to links
      }
    });
  }

  // === LIVE PREVIEW WHILE CHOOSING COLOR ===
  const bgPicker = document.getElementById("contact_bg_picker");
  const titlePicker = document.getElementById("contact_title_picker");
  const fontPicker = document.getElementById("contact_font_picker");

  if (bgPicker) {
    bgPicker.addEventListener("input", () => {
      contactSection.style.backgroundColor = bgPicker.value;
    });
  }
  if (titlePicker && titleEl) {
    titlePicker.addEventListener("input", () => {
      titleEl.style.color = titlePicker.value;
    });
  }
  if (fontPicker) {
    fontPicker.addEventListener("input", () => {
      contactSection.style.color = fontPicker.value;
      navLinks.forEach(el => el.style.color = fontPicker.value); // apply to links
    });
  }
});
</script>
