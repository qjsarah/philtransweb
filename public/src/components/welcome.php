<?php
include 'backend/config.php';

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'phone_image','welcome_title_color','welcome_desc_color'];
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
            <img src="<?php echo '../main/images/intro_section/' . htmlspecialchars($content['phone_image'] ?? 'welcome_img.png'); ?>" 
     class="phone1 current-cms-img img-fluid" 
     data-cms-key="phone_image" 
     alt="welcome image">     
        <?php if (isset($_SESSION['user_id'])): ?>
            <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-3 py-2 mt-2 d-block mx-auto " style="border-color: black;"  onclick="toggleEditAll(this)" data-modal-target=".edit-welcome-image">Change Image</button>      
        <?php endif; ?>
        </div>
        <div class="my-5  fs-5">

            <!-- Display Section -->
            <div id="all-display">
                <h4 class="fw-bold display-5" style="color: <?php echo htmlspecialchars($content['welcome_title_color'] ?? '#FFFFFF'); ?>;"><?php echo htmlspecialchars($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?></h4>


                <p class="textstyle  mb-4 fs-4" style="color: <?php echo htmlspecialchars($content['welcome_desc_color'] ?? '#FFFFFF'); ?>;">
                    <?php echo htmlspecialchars($content['paragraph2'] ?? "..."); ?>
                </p>

                <p class="textstyle mb-4 fs-4" style="color: <?php echo htmlspecialchars($content['welcome_desc_color'] ?? '#FFFFFF'); ?>;">
                    <?php echo htmlspecialchars($content['paragraph3'] ?? "..."); ?>
                </p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <button type="button" class="contact_button rounded text-dark w-50 w-md-25 px-3 py-2 mt-2 " style="border-color: black;"onclick="toggleEditAll(this)" data-modal-target=".welcomeContent">Edit Content</button>
            <?php endif; ?>
            </div>

           <!-- Welcome Content Modal -->
<div class="modal fade welcomeContent" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header px-4 border-bottom-0">
        <h3 class="modal-title fw-bold">Edit Welcome Section Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-4">
        <hr>
        <form method="POST" action="backend/savecms.php" class="form">
          <div class="d-flex flex-column flex-md-row align-items-start gap-4">
            <!-- Color Pickers -->
            <div style="min-width: 200px; width: 100%; max-width: 200px;">
              <label for="welcome_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
              <input type="text" id="welcome_title_hex" name="welcome_title_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['welcome_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="welcome_title_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['welcome_title_color'] ?? '#1a1a1a'); ?>">

              <label for="welcome_desc_color" class="form-label fw-bold text-secondary mt-3">Description Font Color:</label>
              <input type="text" id="welcome_desc_hex" name="welcome_desc_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['welcome_desc_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="welcome_desc_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['welcome_desc_color'] ?? '#1a1a1a'); ?>">
            </div>

            <!-- Text Areas -->
            <div class="flex-grow-1 w-100">
              <label for="welcome" class="form-label fw-bold text-secondary">Welcome Title:</label>
              <textarea name="welcome" class="form-control mb-3 rounded-1 p-2" rows="3" style="border-color: black;"><?php echo htmlspecialchars($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?></textarea>

              <label for="paragraph2" class="form-label fw-bold text-secondary mt-2">Paragraph 1:</label>
              <textarea name="paragraph2" class="form-control rounded-1 p-2" rows="4" style="border-color: black;"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?></textarea>

              <label for="paragraph3" class="form-label fw-bold text-secondary mt-2">Paragraph 2:</label>
              <textarea name="paragraph3" class="form-control mb-1 rounded-1 p-2" rows="4" style="border-color: black;"><?php echo htmlspecialchars($content['paragraph3'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?></textarea>
            </div>
          </div>

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
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Title and description color inputs
    const titleColorPicker = document.getElementById("welcome_title_color");
    const titleHexInput    = document.getElementById("welcome_title_hex");
    const descColorPicker  = document.getElementById("welcome_desc_color");
    const descHexInput     = document.getElementById("welcome_desc_hex");

    // Elements to preview live
    const titleElement = document.querySelector("#all-display h4") || document.querySelector(".fw-bold.display-5");
    const descElements = document.querySelectorAll("#all-display p"); // paragraph2 = descElements[0], paragraph3 = descElements[1]

    const form = document.querySelector(".welcomeContent form");

    // Store original values from PHP content
    const original = {
        titleColor: '<?php echo addslashes($content['welcome_title_color'] ?? '#FFFFFF'); ?>',
        descColor: '<?php echo addslashes($content['welcome_desc_color'] ?? '#FFFFFF'); ?>',
        titleText: '<?php echo addslashes($content['welcome'] ?? "Welcome to Philippine Transportation App System"); ?>',
        paragraph2Text: '<?php echo addslashes($content['paragraph2'] ?? "PTAS breaks the mold..."); ?>',
        paragraph3Text: '<?php echo addslashes($content['paragraph3'] ?? "In essence, PTAS represents a paradigm shift..."); ?>'
    };

    // Title color live sync
    titleColorPicker.addEventListener("input", function () {
        titleHexInput.value = this.value;
        if(titleElement) titleElement.style.color = this.value;
    });
    titleHexInput.addEventListener("input", function () {
        titleColorPicker.value = this.value;
        if(titleElement) titleElement.style.color = this.value;
    });

    // Description color live sync
    descColorPicker.addEventListener("input", function () {
        descHexInput.value = this.value;
        descElements.forEach(el => el.style.color = this.value);
    });
    descHexInput.addEventListener("input", function () {
        descColorPicker.value = this.value;
        descElements.forEach(el => el.style.color = this.value);
    });

    // Ensure correct values are sent on submit
    if(form) {
        form.addEventListener("submit", function () {
            titleColorPicker.value = titleHexInput.value;
            descColorPicker.value  = descHexInput.value;
        });
    }

    // Reset preview to original values when modal is cancelled or closed
    const modal = document.querySelector(".welcomeContent");
    if(modal){
        const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");
        function resetPreview() {
            if(titleElement) titleElement.style.color = original.titleColor;
            descElements.forEach(el => el.style.color = original.descColor);
            if(titleElement) titleElement.textContent = original.titleText;
            if(descElements[0]) descElements[0].textContent = original.paragraph2Text;
            if(descElements[1]) descElements[1].textContent = original.paragraph3Text;
            if(form){
                form.welcome.value = original.titleText;
                form.paragraph2.value = original.paragraph2Text;
                form.paragraph3.value = original.paragraph3Text;
            }
        }
        if(cancelBtn) cancelBtn.addEventListener("click", resetPreview);
        modal.addEventListener('hidden.bs.modal', resetPreview);
    }
});
</script>
