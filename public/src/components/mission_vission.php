<?php
include 'backend/config.php';

$keys = [
    'mission_title',
    'vision_title',
    'mission_content',
    'vision_content',
    'mission_image',
    'vision_image',
    'ads3',
    'ads4',
    'mission_title_color',
    'mission_content_color',
    'vision_title_color',
    'vision_content_color'
];
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
          <h1 class="fw-bold display-4" style="color: <?php echo htmlspecialchars($content['mission_title_color'] ?? '#1a1a1a'); ?>">
            <?php echo htmlspecialchars($content['mission_title'] ?? "MISSION"); ?>
          </h1>
          <p class="mt-4 fs-4" style="color: <?php echo htmlspecialchars($content['mission_content_color'] ?? '#1a1a1a'); ?>">
            <?php echo htmlspecialchars($content['mission_content'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income. By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience. Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?></p>
        </div>
     </div>

    <div class="vision row align-items-center flex-lg-row-reverse mt-5">
      <div class="col-md-5 text-center mb-md-0 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>"
            alt="Mission Image" class="img-fluid current-cms-img" style="max-width: 350px;"
            data-cms-key="vision_image">
      </div>

      <div class="col-12 col-lg-7 text-end">
        <h1 class="fw-bold display-4" style="color: <?php echo htmlspecialchars($content['vision_title_color'] ?? '#1a1a1a'); ?>">
          <?php echo htmlspecialchars($content['vision_title'] ?? "VISION"); ?>
        </h1>
        <p class="mt-4 fs-4" style="color: <?php echo htmlspecialchars($content['vision_content_color'] ?? '#1a1a1a'); ?>"><?php echo htmlspecialchars($content['vision_content'] ?? "In a future powered by our app, tricycle rides becomeeffortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service. We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income). Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being. This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?></p>
      </div>
    </div>

      <div class="text-center mb-5 d-flex gap-3">
         <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" onclick="toggleEditAll(this)" data-modal-target=".mvContent">Edit Contents</button>
        <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;"onclick="toggleEditAll(this)" data-modal-target=".mission-iamge">Change Images</button>
      </div>
    </div>

<!-- Modal for Editing Mission & Vision Content -->
<div class="modal fade mvContent" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header px-4 border-bottom-0">
        <h3 class="modal-title fw-bold">Edit Mission & Vision Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <hr>
        <form method="POST" id="mvForm" action="backend/savecms.php" class="form">
          <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">

            <!-- Color Pickers Column -->
            <div style="min-width: 250px; width: 100%; max-width: 250px;">
              <!-- Mission Title Color -->
              <label class="form-label fw-bold text-secondary">Mission Title Font Color:</label>
              <input type="text" id="mission_title_hex" name="mission_title_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['mission_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="mission_title_color" class="form-control form-control-color mb-4" style="height: 44px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['mission_title_color'] ?? '#1a1a1a'); ?>">

              <!-- Mission Content Color -->
              <label class="form-label fw-bold text-secondary">Mission Content Font Color:</label>
              <input type="text" id="mission_content_hex" name="mission_content_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['mission_content_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="mission_content_color" class="form-control form-control-color mb-5" style="height: 44px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['mission_content_color'] ?? '#1a1a1a'); ?>">

              <!-- Vision Title Color -->
              <label class="form-label fw-bold text-secondary">Vision Title Font Color:</label>
              <input type="text" id="vision_title_hex" name="vision_title_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['vision_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="vision_title_color" class="form-control form-control-color mb-4" style="height: 44px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['vision_title_color'] ?? '#1a1a1a'); ?>">

              <!-- Vision Content Color -->
              <label class="form-label fw-bold text-secondary">Vision Content Font Color:</label>
              <input type="text" id="vision_content_hex" name="vision_content_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['vision_content_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="vision_content_color" class="form-control form-control-color mb-2" style="height: 44px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['vision_content_color'] ?? '#1a1a1a'); ?>">
            </div>

            <!-- Text Areas Column -->
            <div class="flex-grow-1 w-100">
              <label class="form-label fw-bold text-secondary">Mission Title:</label>
              <textarea name="mission_title" class="form-control rounded-1 p-2 mb-3" rows="3" style="border-color: black;"><?= htmlspecialchars($content['mission_title'] ?? 'MISSION'); ?></textarea>

              <label class="form-label fw-bold text-secondary mt-2">Mission Content:</label>
              <textarea name="mission_content" class="form-control rounded-1 p-2 mb-4" rows="4" style="border-color: black;"><?= htmlspecialchars($content['mission_content'] ?? 'Our mission is to empower every tricycle driver in the Philippines...'); ?></textarea>

              <label class="form-label fw-bold text-secondary">Vision Title:</label>
              <textarea name="vision_title" class="form-control rounded-1 p-2 mb-3" rows="3" style="border-color: black;"><?= htmlspecialchars($content['vision_title'] ?? 'VISION'); ?></textarea>

              <label class="form-label fw-bold text-secondary mt-2">Vision Content:</label>
              <textarea name="vision_content" class="form-control rounded-1 p-2 mb-2" rows="5" style="border-color: black;"><?= htmlspecialchars($content['vision_content'] ?? 'In a future powered by our app, tricycle rides become effortless...'); ?></textarea>
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


<!-- Image Edit Modal (updated with Ads design) -->
<div class="modal fade mission-iamge" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Edit Mission & Vission Images</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-4">
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-5">

          <!-- Mission Image -->
          <div class="">
            <label class="form-label fw-bold text-secondary">Mission Image:</label>
            <div class="">

              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png'); ?>" 
              alt="Mission Image" 
              class="img-fluid mb-2 current-cms-img" 
              data-cms-key="mission_image" 
              style="max-width: 100%; height: auto;">
              <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="mission_image" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>
          </div>

          <!-- Vision Image -->
          <div class="">
              <label class="form-label fw-bold text-secondary">Vision Image:</label>
              <div class="">
                <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png'); ?>" 
                alt="Vision Image" 
                class="img-fluid mb-2 current-cms-img" 
                data-cms-key="vision_image" 
                style="max-width: 100%; height: auto;">
                <div class="upload-box uploadBox">
                  <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="vision_image" accept="image/*">
                  <p>Click or drag a file here to upload</p>
                </div>
              </div>
          </div>

        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


  <?php else: ?>
    <!-- PUBLIC VIEW -->
    <div class="mission row align-items-center">
      <div class="col-md-5 text-center mb-5 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_image'] ?? 'mission.png')?>"
      alt="Mission Image" class="img-fluid" style="max-width: 350px;">
      </div>
      <div class="col-12 col-lg-7 text-start">
        <h1 class="fw-bold display-4" style="color: <?php echo htmlspecialchars($content['mission_title_color'] ?? '#1a1a1a'); ?>">
          <?php echo htmlspecialchars($content['mission_title'] ?? "MISSION"); ?>
        </h1>
        <p class="mt-4 fs-4" style="color: <?php echo htmlspecialchars($content['mission_content_color'] ?? '#1a1a1a'); ?>">
    <?php echo htmlspecialchars($content['mission_content'] ?? "Our mission is to empower every tricycle driver..."); ?>
</p>

      </div>
    </div>

    <div class="vision row align-items-center flex-lg-row-reverse mt-5 mb-5">
      <div class="col-md-5 text-center mb-5 mb-md-0 d-none d-lg-block">
        <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_image'] ?? 'vision.png')?>"
              alt="Vision Image" class="img-fluid" style="max-width: 350px;">
      </div>
      <div class="col-12 col-lg-7 text-end">
        <h1 class="fw-bold display-4" style="color: <?php echo htmlspecialchars($content['vision_title_color'] ?? '#1a1a1a'); ?>">
          <?php echo htmlspecialchars($content['vision_title'] ?? "VISION"); ?>
        </h1>
        <p class="mt-4 fs-4"><?php echo htmlspecialchars($content['vision_content'] ?? "In a future powered by our app..."); ?></p>
      </div>
    </div>
  <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Modal + form
  const modal  = document.querySelector('.mvContent');
  const form   = document.getElementById('mvForm');
  if (!modal || !form) return;

  // Mission fields (color + hex)
  const missionTitleHex     = document.getElementById('mission_title_hex');
  const missionTitleColor   = document.getElementById('mission_title_color');
  const missionContentHex   = document.getElementById('mission_content_hex');
  const missionContentColor = document.getElementById('mission_content_color');

  // Vision fields (color + hex)
  const visionTitleHex      = document.getElementById('vision_title_hex');
  const visionTitleColor    = document.getElementById('vision_title_color');
  const visionContentHex    = document.getElementById('vision_content_hex');
  const visionContentColor  = document.getElementById('vision_content_color');

  // Textareas (by name, inside the form)
  const missionTitleInput   = form.elements['mission_title'];
  const missionContentInput = form.elements['mission_content'];
  const visionTitleInput    = form.elements['vision_title'];
  const visionContentInput  = form.elements['vision_content'];

  // Live preview elements on the page
  const missionTitleEl   = document.querySelector('#mv-view .mission h1');
  const missionContentEl = document.querySelector('#mv-view .mission p');
  const visionTitleEl    = document.querySelector('#mv-view .vision h1');
  const visionContentEl  = document.querySelector('#mv-view .vision p');

  // Helper: valid HEX?
  const isHex = (v) => /^#([0-9A-F]{3}|[0-9A-F]{6})$/i.test(v);

  // Sync color picker <-> hex input and apply to preview
  function bindColorPair(picker, hex, targets) {
    if (!picker || !hex || !targets?.length) return;

    picker.addEventListener('input', () => {
      hex.value = picker.value.toUpperCase();
      targets.forEach(t => t && (t.style.color = picker.value));
    });

    hex.addEventListener('input', () => {
      if (isHex(hex.value)) {
        picker.value = hex.value.toUpperCase();
        targets.forEach(t => t && (t.style.color = hex.value));
      }
    });
  }

  // Sync textareas to preview
  function bindText(input, target) {
    if (!input || !target) return;
    input.addEventListener('input', () => {
      target.textContent = input.value;
    });
  }

  // Bind all colors
  bindColorPair(missionTitleColor,   missionTitleHex,   [missionTitleEl]);
  bindColorPair(missionContentColor, missionContentHex, [missionContentEl]);
  bindColorPair(visionTitleColor,    visionTitleHex,    [visionTitleEl]);
  bindColorPair(visionContentColor,  visionContentHex,  [visionContentEl]);

  // Bind all texts
  bindText(missionTitleInput,   missionTitleEl);
  bindText(missionContentInput, missionContentEl);
  bindText(visionTitleInput,    visionTitleEl);
  bindText(visionContentInput,  visionContentEl);

  // On submit, ensure pickers reflect hex (if user typed hex)
  form.addEventListener('submit', () => {
    if (missionTitleHex && isHex(missionTitleHex.value))       missionTitleColor.value   = missionTitleHex.value;
    if (missionContentHex && isHex(missionContentHex.value))   missionContentColor.value = missionContentHex.value;
    if (visionTitleHex && isHex(visionTitleHex.value))         visionTitleColor.value    = visionTitleHex.value;
    if (visionContentHex && isHex(visionContentHex.value))     visionContentColor.value  = visionContentHex.value;
  });

  // Reset routine: reset the form to server-rendered defaults and refresh preview
  function resetFormAndPreview() {
    // Reset inputs to the values from the original HTML (PHP-rendered)
    form.reset();

    // After reset, mirror picker <-> hex and update preview
    function syncBack(picker, hex, targets) {
      if (!picker || !hex || !targets?.length) return;
      // Make hex show current picker value (and uppercase)
      hex.value = (picker.value || '').toUpperCase();
      targets.forEach(t => t && (t.style.color = picker.value || ''));
    }

    syncBack(missionTitleColor,   missionTitleHex,   [missionTitleEl]);
    syncBack(missionContentColor, missionContentHex, [missionContentEl]);
    syncBack(visionTitleColor,    visionTitleHex,    [visionTitleEl]);
    syncBack(visionContentColor,  visionContentHex,  [visionContentEl]);

    // Update preview text from (now-reset) textareas
    if (missionTitleEl   && missionTitleInput)   missionTitleEl.textContent   = missionTitleInput.value;
    if (missionContentEl && missionContentInput) missionContentEl.textContent = missionContentInput.value;
    if (visionTitleEl    && visionTitleInput)    visionTitleEl.textContent    = visionTitleInput.value;
    if (visionContentEl  && visionContentInput)  visionContentEl.textContent  = visionContentInput.value;
  }

  // Cancel button (any with data-bs-dismiss="modal" inside this modal)
  const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");
  if (cancelBtn) cancelBtn.addEventListener('click', resetFormAndPreview);

  // Also reset when the modal fully closes (Esc, backdrop click, etc.)
  modal.addEventListener('hidden.bs.modal', resetFormAndPreview);
});
</script>
