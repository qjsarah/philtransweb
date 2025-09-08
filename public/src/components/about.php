<?php
include 'backend/config.php';

// Keys to fetch from `aboutus` table
$keys = ['aboutus', 'PTAS', 'paragraph4', 'tricycle', 'aboutus_bgcolor', 'aboutus_title_color','aboutus_sub_color', 'aboutus_desc_color'];
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
$titleColor = htmlspecialchars($content['aboutus_title_color'] ?? '#1a1a1a');
$subColor = htmlspecialchars($content['aboutus_sub_color'] ?? '#1a1a1a');
$descColor = htmlspecialchars($content['aboutus_desc_color'] ?? '#1a1a1a');
?>

<section class="text-white my-5 aboutus-section" style="background-color: <?= $bgColor ?>; height: auto;">
    <div class="d-flex flex-column flex-lg-row w-100 justify-content-between py-5 container">
        <div class="col-lg-6 about-left">
            <h1 class="fw-bold display-5 about-title" style="color: <?= $titleColor ?>;"><?= htmlspecialchars($content['aboutus'] ?? "ABOUT US") ?></h1>
            <h2 class="fw-semibold mb-3 mt-4 about-subtitle" style="color: <?= $subColor ?>;"><?= htmlspecialchars($content['PTAS'] ?? "PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY") ?></h2>
            <p class="fs-5 about-desc" style="color: <?= $descColor ?>;"><?= htmlspecialchars($content['paragraph4'] ?? "") ?></p>
<?php if (isset($_SESSION['user_id'])): ?>
            <button type="button" class="contact_button w-50 px-3 py-2 mt-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".aboutContent">Edit Content</button>
<?php endif; ?>

        </div>

        <div class="col-lg-6 text-center mt-5 about-right">
            <img src="../main/images/about_section/<?= htmlspecialchars($content['tricycle'] ?? 'desktop_trycicle.png') ?>" alt="Tricycle" class="img-fluid w-75 current-cms-img">
<?php if (isset($_SESSION['user_id'])): ?>
            <button type="button" class="contact_button w-50 px-3 py-2 mt-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".edit-about-image">Change Image</button>
<?php endif; ?>
        </div>
    </div>

    <!-- Modal for Editing Content -->
    <div class="modal fade aboutContent" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
          <div class="modal-header px-4 border-bottom-0">
            <h3 class="modal-title fw-bold">Edit About Us Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body px-4">
            <hr>
            <form method="POST" id="aboutusForm" action="backend/savecms.php" class="form">
              <!-- Background Color -->
              <label class="form-label fw-bold text-secondary">Background Color:</label>
              <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                <input type="text" id="aboutus_bg_hex" class="form-control text-uppercase mb-1 mb-md-0" maxlength="7" style="border-color: black; flex: 0 0 27%;" value="<?= $bgColor ?>" name="aboutus_bgcolor">
                <input type="color" id="aboutus_bgcolor" class="form-control form-control-color w-100 w-md-auto" style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;" value="<?= $bgColor ?>" name="aboutus_bgcolor">
              </div>

              <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                <!-- Color Picker Container -->
                <div style="min-width: 200px; width: 100%; max-width: 200px;">
                  <!-- Title Color -->
                  <label for="aboutus_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
                  <input type="text" id="aboutus_title_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= $titleColor ?>">
                  <input type="color" id="aboutus_title_color" name="aboutus_title_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?= $titleColor ?>">

                  <!-- Subtitle Color -->
                  <label for="aboutus_sub_color" class="form-label fw-bold text-secondary mt-2">Subtitle Font Color:</label>
                  <input type="text" id="aboutus_sub_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black; width: 100%;" value="<?= $subColor ?>">
                  <input type="color" id="aboutus_sub_color" name="aboutus_sub_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?= $subColor ?>">

                  <!-- Description Color -->
                  <label for="aboutus_desc_color" class="form-label fw-bold text-secondary mt-2">Description Font Color:</label>
                  <input type="text" id="aboutus_desc_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black; width: 100%;" value="<?= $descColor ?>">
                  <input type="color" id="aboutus_desc_color" name="aboutus_desc_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?= $descColor ?>">
                </div>

                <!-- Textarea Container -->
                <div class="flex-grow-1 w-100">
                  <label for="aboutus" class="form-label fw-bold text-secondary">Title:</label>
                  <textarea name="aboutus" class="form-control rounded-1 p-2 mb-3" rows="3" style="border-color: black; width: 100%;"><?= htmlspecialchars($content['aboutus'] ?? "ABOUT US") ?></textarea>

                  <label for="PTAS" class="form-label fw-bold text-secondary">Subtitle:</label>
                  <textarea name="PTAS" class="form-control rounded-1 p-2 mb-3" rows="3" style="border-color: black; width: 100%;"><?= htmlspecialchars($content['PTAS'] ?? "") ?></textarea>

                  <label for="paragraph4" class="form-label fw-bold text-secondary">Description:</label>
                  <textarea name="paragraph4" class="form-control rounded-1 p-2 mb-3" rows="5" style="border-color: black; width: 100%;"><?= htmlspecialchars($content['paragraph4'] ?? "") ?></textarea>
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

<!-- About Image Edit Modal -->
<div class="modal fade edit-about-image" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header px-4 border-bottom-0">
                <h3 class="modal-title fw-bold text-dark">About Image Content</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <hr>
                <form class="form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center">
                        <div class="me-5 w-75 text-center">
                            <img src="../main/images/about_section/<?= htmlspecialchars($content['tricycle'] ?? 'trycicle.png') ?>" 
                                alt="Tricycle" 
                                class="img-fluid current-cms-img w-50 mb-2" 
                                data-cms-key="tricycle">
                            <div class="upload-box uploadBox">
                                <input type="file" 
                                    class="form-control cms-image-input fileInput mx-auto" 
                                    data-cms-key="tricycle" 
                                    name="tricycle" 
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

</section>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const bgPicker = document.getElementById("aboutus_bgcolor");
    const bgHex = document.getElementById("aboutus_bg_hex");

    const titlePicker = document.getElementById("aboutus_title_color");
    const titleHex = document.getElementById("aboutus_title_hex");

    const subPicker = document.getElementById("aboutus_sub_color");
    const subHex = document.getElementById("aboutus_sub_hex");

    const descPicker = document.getElementById("aboutus_desc_color");
    const descHex = document.getElementById("aboutus_desc_hex");

    const section = document.querySelector(".aboutus-section");
    const titleEl = document.querySelector(".about-title");
    const subEl = document.querySelector(".about-subtitle");
    const descEl = document.querySelector(".about-desc");

    const form = document.getElementById("aboutusForm");
    const modal = document.querySelector(".aboutContent");
    const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");

    // Store original values from PHP
    const original = {
        bgColor: "<?= $bgColor ?>",
        titleColor: "<?= $titleColor ?>",
        subColor: "<?= $subColor ?>",
        descColor: "<?= $descColor ?>",
        titleText: `<?= addslashes($content['aboutus'] ?? "ABOUT US") ?>`,
        subText: `<?= addslashes($content['PTAS'] ?? "") ?>`,
        descText: `<?= addslashes($content['paragraph4'] ?? "") ?>`
    };

    // Sync function
    function syncColor(picker, hexInput, elements, isBackground=false){
        picker.addEventListener("input", () => {
            hexInput.value = picker.value.toUpperCase();
            if(isBackground) section.style.backgroundColor = picker.value;
            else elements.forEach(el=>el.style.color=picker.value);
        });
        hexInput.addEventListener("input", () => {
            if(/^#([0-9A-F]{3}){1,2}$/i.test(hexInput.value)){
                picker.value = hexInput.value.toUpperCase();
                if(isBackground) section.style.backgroundColor = hexInput.value;
                else elements.forEach(el=>el.style.color=hexInput.value);
            }
        });
    }

    // Apply syncing
    syncColor(bgPicker, bgHex, [], true);
    syncColor(titlePicker, titleHex, [titleEl]);
    syncColor(subPicker, subHex, [subEl]);
    syncColor(descPicker, descHex, [descEl]);

    // Reset function when modal is closed/cancelled
    function resetPreview() {
        // Reset colors
        bgPicker.value = original.bgColor;
        bgHex.value = original.bgColor;
        titlePicker.value = original.titleColor;
        titleHex.value = original.titleColor;
        subPicker.value = original.subColor;
        subHex.value = original.subColor;
        descPicker.value = original.descColor;
        descHex.value = original.descColor;

        // Reset live preview
        section.style.backgroundColor = original.bgColor;
        titleEl.style.color = original.titleColor;
        subEl.style.color = original.subColor;
        descEl.style.color = original.descColor;

        // Reset text
        titleEl.textContent = original.titleText;
        subEl.textContent = original.subText;
        descEl.textContent = original.descText;

        // Reset form textareas
        form.aboutus.value = original.titleText;
        form.PTAS.value = original.subText;
        form.paragraph4.value = original.descText;
    }

    cancelBtn.addEventListener("click", resetPreview);
    modal.addEventListener('hidden.bs.modal', resetPreview);
});
</script>
