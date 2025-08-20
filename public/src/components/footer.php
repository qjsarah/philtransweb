<?php
include 'backend/config.php';

// Footer keys to fetch
$keys = ['footer_copyright', 'footer_credits', 'footer_bg_color', 'footer_font_color'];

// Dynamically create placeholders
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT `key_name`, `content` FROM `footer` WHERE `key_name` IN ($placeholders)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters dynamically
$types = str_repeat('s', count($keys));
$stmt->bind_param($types, ...$keys);

// Execute
$stmt->execute();

// Fetch results
$result = $stmt->get_result();
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}

// Close statement
$stmt->close();
?>
<footer class="text-center text-white footer-section pb-3" 
        style="background-color: <?php echo htmlspecialchars($content['footer_bg_color'] ?? '#BF0D3D'); ?>; color: <?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>;">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mb-4">
            <button type="button" class="contact_button px-5 py-2 rounded text-white w-25 w-md-auto" onclick="toggleEditAll(this)" data-modal-target=".footerContent">Edit Contents</button>
        </div>
    <?php endif; ?>

    <div class="w-75 d-flex flex-column flex-md-row text-center justify-content-md-between mx-auto" style="color: <?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>;">
        <p class="mb-2 mb-md-0"><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></p>
        <p class="mb-0" >
            <?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By "); ?>
            <a href="https://bb88advertising.com/" target="_blank" 
               style="text-decoration: none; color: inherit;" 
               onmouseover="this.style.color='#a1a1a1ff'" 
               onmouseout="this.style.color='inherit'">
               BB 88 Advertising and Digital Solutions Inc.
            </a>
        </p>
    </div>

    <!-- Footer Edit Modal -->
    <div class="modal fade footerContent" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                
                <div class="modal-header px-4 border-bottom-0">
                    <h3 class="modal-title fw-bold">Edit Footer Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">
                    <hr>
                    <form id="footer-content-form" method="POST" action="backend/savecms.php">
                        
                        <!-- Background Color -->
                        <label class="form-label fw-bold text-secondary">Background Color:</label>
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                            <input type="text" id="footer_bg_hex" name="footer_bg_color"  
                                class="form-control text-uppercase mb-1 mb-md-0" maxlength="10"
                                style="border-color: black; flex: 0 0 27%;"
                                value="<?php echo htmlspecialchars($content['footer_bg_color'] ?? '#1a1a1a'); ?>">
                            <input type="color" class="form-control form-control-color w-100 w-md-auto mb-2"
                                id="footer_bg_picker"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"  
                                value="<?php echo htmlspecialchars($content['footer_bg_color'] ?? '#1a1a1a'); ?>">
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                            <!-- Color Picker -->
                            <div style="min-width: 200px; width: 100%; max-width: 200px;">
                                <label class="form-label fw-bold text-secondary">Font Color:</label>
                                <input type="text" id="footer_font_hex" name="footer_font_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['footer_font_color'] ?? '#1a1a1a'); ?>">
                                <input type="color" id="footer_font_picker" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>">
                            </div>

                            <!-- Textareas -->
                            <div class="flex-grow-1 w-100">
                                <!-- Copyright -->
                                <label class="form-label fw-bold text-secondary">Copyright:</label>
                                <textarea name="footer_copyright" class="form-control mb-3 rounded-1 p-2" style="border-color: black;" rows="3"><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></textarea>

                                <!-- Credits -->
                                <label class="form-label fw-bold text-secondary pt-2 mt-3">Credits:</label>
                                <textarea name="footer_credits" class="form-control mb-3 rounded-1 p-2" style="border-color: black;"rows="3"><?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By BB 88 Advertising and Digital Solutions Inc."); ?></textarea>
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
</footer>

<script>
// Function to sync hex input and color picker with validation
function syncColorInputs(hexId, pickerId) {
  const hexInput = document.getElementById(hexId);
  const picker = document.getElementById(pickerId);
  if (!hexInput || !picker) return;

  // Hex → Picker
  hexInput.addEventListener("input", () => {
    let val = hexInput.value.trim();
    if (!val.startsWith("#")) val = "#" + val;
    if (/^#([0-9A-Fa-f]{3})$/.test(val)) {
      val = "#" + val[1]+val[1]+val[2]+val[2]+val[3]+val[3];
    }
    if (/^#([0-9A-Fa-f]{6})$/.test(val)) {
      picker.value = val.toUpperCase();
      hexInput.value = val.toUpperCase();
      picker.dispatchEvent(new Event("input")); 
    }
  });

  // Picker → Hex
  picker.addEventListener("input", () => {
    hexInput.value = picker.value.toUpperCase();
  });
}

// Apply syncing for footer color inputs
syncColorInputs("footer_bg_hex", "footer_bg_picker");
syncColorInputs("footer_font_hex", "footer_font_picker");

document.addEventListener("DOMContentLoaded", function() {
  const footer = document.querySelector(".footer-section");
  const footerModal = document.querySelector(".footerContent");
  const bgHex = document.getElementById("footer_bg_hex");
  const bgPicker = document.getElementById("footer_bg_picker");
  const fontHex = document.getElementById("footer_font_hex");
  const fontPicker = document.getElementById("footer_font_picker");
  const copyrightInput = footerModal.querySelector('textarea[name="footer_copyright"]');
  const creditsInput = footerModal.querySelector('textarea[name="footer_credits"]');

  if (!footer || !footerModal || !bgHex || !bgPicker || !fontHex || !fontPicker) return;

  // Store original colors and text when modal opens
  let originalBg = footer.style.backgroundColor || "#ffffff";
  let originalFont = footer.style.color || "#000000";
  let originalCopyright = copyrightInput ? copyrightInput.value : "";
  let originalCredits = creditsInput ? creditsInput.value : "";

  footerModal.addEventListener("show.bs.modal", () => {
    originalBg = footer.style.backgroundColor || "#ffffff";
    originalFont = footer.style.color || "#000000";
    originalCopyright = copyrightInput ? copyrightInput.value : "";
    originalCredits = creditsInput ? creditsInput.value : "";

    bgHex.value = rgbToHex(originalBg);
    bgPicker.value = rgbToHex(originalBg);
    fontHex.value = rgbToHex(originalFont);
    fontPicker.value = rgbToHex(originalFont);
  });

  // Reset everything when modal closes or Cancel is clicked
  function resetFooterModal() {
    footer.style.backgroundColor = originalBg;
    setFooterFontColor(originalFont);
    bgHex.value = rgbToHex(originalBg);
    bgPicker.value = rgbToHex(originalBg);
    fontHex.value = rgbToHex(originalFont);
    fontPicker.value = rgbToHex(originalFont);

    if (copyrightInput) copyrightInput.value = originalCopyright;
    if (creditsInput) creditsInput.value = originalCredits;
  }

  footerModal.addEventListener("hidden.bs.modal", resetFooterModal);
  const cancelBtn = footerModal.querySelector('[data-bs-dismiss="modal"]');
  if (cancelBtn) cancelBtn.addEventListener("click", resetFooterModal);

  // Live preview while editing
  bgPicker.addEventListener("input", () => footer.style.backgroundColor = bgPicker.value);
  fontPicker.addEventListener("input", () => setFooterFontColor(fontPicker.value));

  function setFooterFontColor(color) {
    footer.style.color = color;
    footer.querySelectorAll("p, a, span, h5, h6").forEach(el => el.style.color = color);
  }

  // Utility: Convert RGB to HEX
  function rgbToHex(rgb) {
    if (!rgb) return "#000000";
    const result = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/.exec(rgb.replace(/\s/g,''));
    if (!result) return rgb; // already hex
    return "#" + [1,2,3].map(i => ("0" + parseInt(result[i]).toString(16)).slice(-2)).join("").toUpperCase();
  }
});
</script>
