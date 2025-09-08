<?php
include 'backend/config.php';

$keys = ['services_image', 'service_title', 'services_bg_color', 'services_title_color', 'card_title_color', 'card_desc_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM services WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$card_query = "SELECT * FROM card_table ORDER BY id DESC";
$card_result = $conn->query($card_query);
$cards = [];

if ($card_result && $card_result->num_rows > 0) {
    while ($row = $card_result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<section class="servicetext services pb-5" style="background-color: <?php echo htmlspecialchars($content['services_bg_color'] ?? '#000000'); ?>;">

<?php if (isset($_SESSION['user_id'])): ?>
    <h4 class="text-center pt-5 display-5 fw-bold"  style="color: <?php echo htmlspecialchars($content['services_title_color'] ?? '#FFFFFF'); ?>;">
        <?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?>
    </h4>
    <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png')?>"
         alt="Service Image" 
         class="bgservice w-75 img-fluid py-3 mx-auto d-block current-cms-img" 
         data-cms-key="services_image">

    <?php foreach ($cards as $index => $card): ?>
        <div class="card<?php echo $index + 1; ?> services-card w-75 p-3 mx-auto d-block text-white rounded my-3">
            <h3 style="color: <?php echo htmlspecialchars($content['card_title_color'] ?? '#FFFFFF'); ?>;"><?php echo strtoupper(htmlspecialchars($card['title'])); ?></h3>
            <p style="color: <?php echo htmlspecialchars($content['card_desc_color'] ?? '#FFFFFF'); ?>;"><?php echo nl2br(htmlspecialchars($card['content'])); ?></p>
        </div>
    <?php endforeach; ?>

    <div class="text-center mb-5 d-flex justify-content-center gap-3">
        <button type="button" class="contact_button w-25 px-3 py-2 mt-2 rounded text-white" data-bs-toggle="modal" data-bs-target="#serviceModal">
            Edit Content
        </button>
        <button type="button" class="contact_button w-25 px-3 py-2 mt-2 rounded text-white" data-bs-toggle="modal" data-bs-target="#cardsModal">
            Manage Cards
        </button>
        <button type="button" class="contact_button w-25 px-3 py-2 mt-2 rounded text-white" data-bs-toggle="modal" data-bs-target=".edit-services-image">
            Change Image
        </button>
    </div>

   <!-- Service Title Modal -->
<div class="modal fade serviceContent" tabindex="-1" id="serviceModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header">
                <h3 class="modal-title">Edit Services Content Section</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="form">
                
                <!-- Scrollable content -->
                <div class="modal-body" style="max-height: calc(100vh - 150px); overflow-y: auto;">
                    
                    <!-- Background color -->
                    <label for="services_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                        <input type="text"
                            id="services_bg_color_hex"
                            class="form-control text-uppercase mb-1 mb-md-0"
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['services_bg_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color w-100 w-md-auto"
                            id="services_bg_color"
                            name="services_bg_color"
                            style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                            value="<?php echo htmlspecialchars($content['services_bg_color'] ?? '#1a1a1a'); ?>">
                    </div>

                    <!-- Services title color & text -->
                    <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                        <div style="min-width: 200px; width: 100%; max-width: 200px;">
                            <label for="services_bg_color_hex" class="form-label fw-bold text-secondary">Services Title Color:</label>
                            <input type="text"
                                id="services_title_color_hex"
                                class="form-control text-uppercase mb-2"
                                maxlength="10"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                                value="<?php echo htmlspecialchars($content['services_title_color'] ?? '#1a1a1a'); ?>">
                            <input type="color"
                                class="form-control form-control-color w-100 w-md-auto"
                                id="services_title_color"
                                name="services_title_color"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                                value="<?php echo htmlspecialchars($content['services_title_color'] ?? '#1a1a1a'); ?>">
                        </div>

                        <div class="flex-grow-1 w-100">
                            <label class="form-label fw-bold text-secondary">Services Title:</label>
                            <textarea name="service_title" class="form-control mb-3" rows="3" style="border-color: black;"><?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?></textarea>
                        </div>
                    </div>

                    <!-- Card Title Color -->
                    <label for="card_title_color_hex" class="form-label fw-bold text-secondary mb-1">Card Title Font Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                        <input type="text"
                            id="card_title_color_hex"
                            name="card_title_color"
                            class="form-control text-uppercase "
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['card_title_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color"
                            id="card_title_color"
                            name="card_title_color"
                            style="height: 38px; padding: 5px; border-color: black; width: 100%;"
                            value="<?php echo htmlspecialchars($content['card_title_color'] ?? '#1a1a1a'); ?>">
                    </div>

                    <!-- Card Description Color -->
                    <label for="card_desc_color_hex" class="form-label fw-bold text-secondary">Card Description Font Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb">
                        <input type="text"
                            id="card_desc_color_hex"
                            name="card_desc_color"
                            class="form-control text-uppercase"
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['card_desc_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color"
                            id="card_desc_color"
                            name="card_desc_color"
                            style="height: 38px; padding: 5px; border-color: black; width: 100%;"
                            value="<?php echo htmlspecialchars($content['card_desc_color'] ?? '#1a1a1a'); ?>">
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer text-center d-flex flex-column flex-md-row justify-content-center gap-3">
                    <button type="submit" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
                    <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Service Cards Modal -->
    <div class="modal fade serviceCardsModal" tabindex="-1" id="cardsModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 1rem;">
                <div class="modal-header">
                    <h3 class="modal-title">Manage Service Cards</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Font Color -->
                    <div class="text-center">
                        <button id="showAddCardForm" class="services-card w-75 p-3 mx-auto d-block rounded my-3 text-dark fw-bold" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: 2px dashed #aaa;">Add New Card</button>
                    </div>

                    <div id="addCardForm" style="display: none;">
                        <hr>
                        <form action="backend/add_card.php" method="POST" class="w-75 mx-auto">
                            <label for="Card Title" class="form-label fw-bold text-secondary ">Card Title:</label>
                            <input type="text" name="title" class="form-control mb-2 border border-black" placeholder="Card Title" required>

                            <label for="Card Description" class="form-label fw-bold text-secondary">Card Description:</label>
                            <textarea name="content" class="form-control mb-2 border border-black" rows="3" placeholder="Card Description" required></textarea>
                            <button class="contact_button w-25 px-3 py-2 mt-3 rounded text-dark border border-dark d-block mx-auto add-button" type="submit">Add Card</button>
                            
                        </form>
                        <hr>
                    </div>
                    <?php foreach ($cards as $card): ?>
                        <div class="services-card w-75 p-3 mx-auto d-block rounded my-3 text-dark  "
                            style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: none;">
                            <h4><?php echo htmlspecialchars($card['title']); ?></h4>
                            <p><?php echo htmlspecialchars($card['content']); ?></p>

                            <form action="backend/delete_card.php" method="POST" class="delete-form">
                                <input type="hidden" name="id" value="<?php echo $card['id']; ?>">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="contact_button w-25 px-3 py-2 mt-2 rounded text-dark border border-dark delete-button">Delete</button>

                                    <button type="button" class="contact_button w-25 px-3 py-2 mt-2 rounded text-dark border border-dark edit-btn"data-id="<?php echo $card['id']; ?>"data-title="<?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?>"data-content="<?php echo htmlspecialchars($card['content'], ENT_QUOTES); ?>">Edit Content</button>
                                    
                                </div>
                            </form>
                        </div>

                    <?php endforeach; ?>

                <?php include 'service_edit_modal.php'; ?>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- Image Content Modal -->
<div class="modal fade edit-services-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header px-4 border-bottom-0">
        <h3 class="modal-title fw-bold text-dark">Edit Services Image</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <hr>
        <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="form">
          <div class="d-flex justify-content-center">
            <div class="me-5 w-75 text-center">
              <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png'); ?>" 
                   alt="Service Image" 
                   class="img-fluid current-cms-img w-100 mb-2" 
                   data-cms-key="services_image">
              <div class="upload-box uploadBox">
                <input type="file" 
                       class="form-control cms-image-input fileInput mx-auto" 
                       data-cms-key="services_image" 
                       name="services_image" 
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
    <!-- Non-admin view -->
    <h4 class=" text-center pt-5 display-5 fw-bold"  style="color: <?php echo htmlspecialchars($content['download_title_color'] ?? '#FFFFFF'); ?>;"><?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?></h4>
    <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png')?>" 
         alt="Service Image" 
         class="bgservice w-75 img-fluid py-3 mx-auto d-block current-cms-img">
    <?php foreach ($cards as $index => $card): ?>
        <div class="card<?php echo $index + 1; ?> services-card w-75 p-3 mx-auto d-block text-white rounded my-3">
            <h3><?php echo strtoupper(htmlspecialchars($card['title'])); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($card['content'])); ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const bgColorHexInput = document.getElementById('services_bg_color_hex');
    const bgColorPicker = document.getElementById('services_bg_color');

    const titleColorHexInput = document.getElementById('services_title_color_hex');
    const titleColorPicker = document.getElementById('services_title_color');

    const cardTitleHexInput = document.getElementById('card_title_color_hex');
    const cardTitlePicker = document.getElementById('card_title_color');

    const cardDescHexInput = document.getElementById('card_desc_color_hex');
    const cardDescPicker = document.getElementById('card_desc_color');

    const serviceSection = document.querySelector('.servicetext.services');
    const serviceTitle = document.querySelector('.servicetext.services h4');
    const cardTitles = document.querySelectorAll('.services-card h3');
    const cardDescs = document.querySelectorAll('.services-card p');

    const form = document.querySelector('#serviceModal form');
    const modal = document.getElementById('serviceModal');
    const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");

    // Store original values from PHP
    const original = {
        bgColor: "<?= htmlspecialchars($content['services_bg_color'] ?? '#1a1a1a'); ?>",
        titleColor: "<?= htmlspecialchars($content['services_title_color'] ?? '#1a1a1a'); ?>",
        cardTitleColor: "<?= htmlspecialchars($content['card_title_color'] ?? '#1a1a1a'); ?>",
        cardDescColor: "<?= htmlspecialchars($content['card_desc_color'] ?? '#1a1a1a'); ?>",
        titleText: `<?= addslashes($content['service_title'] ?? "SERVICES"); ?>`
    };

    // Sync colors for live preview
    function syncColor(picker, hexInput, elements, isBackground = false) {
        picker.addEventListener("input", () => {
            hexInput.value = picker.value.toUpperCase();
            if (isBackground) serviceSection.style.backgroundColor = picker.value;
            else elements.forEach(el => el.style.color = picker.value);
        });

        hexInput.addEventListener("input", () => {
            if (/^#([0-9A-F]{3}){1,2}$/i.test(hexInput.value)) {
                picker.value = hexInput.value.toUpperCase();
                if (isBackground) serviceSection.style.backgroundColor = hexInput.value;
                else elements.forEach(el => el.style.color = hexInput.value);
            }
        });
    }

    // Attach sync behavior
    syncColor(bgColorPicker, bgColorHexInput, [], true);
    syncColor(titleColorPicker, titleColorHexInput, [serviceTitle]);
    syncColor(cardTitlePicker, cardTitleHexInput, cardTitles);
    syncColor(cardDescPicker, cardDescHexInput, cardDescs);

    // Reset everything on cancel/close
    function resetPreview() {
        bgColorHexInput.value = original.bgColor;
        bgColorPicker.value = original.bgColor;

        titleColorHexInput.value = original.titleColor;
        titleColorPicker.value = original.titleColor;

        cardTitleHexInput.value = original.cardTitleColor;
        cardTitlePicker.value = original.cardTitleColor;

        cardDescHexInput.value = original.cardDescColor;
        cardDescPicker.value = original.cardDescColor;

        serviceSection.style.backgroundColor = original.bgColor;
        serviceTitle.style.color = original.titleColor;
        cardTitles.forEach(el => el.style.color = original.cardTitleColor);
        cardDescs.forEach(el => el.style.color = original.cardDescColor);

        form.service_title.value = original.titleText;
        serviceTitle.textContent = original.titleText;
    }

    cancelBtn.addEventListener("click", resetPreview);
    modal.addEventListener('hidden.bs.modal', resetPreview);

    // -----------------------
    // Add Card / Cancel toggle
    // -----------------------
    const showAddCardBtn = document.getElementById('showAddCardForm');
    const addCardForm = document.getElementById('addCardForm');

    showAddCardBtn.addEventListener('click', function () {
        if (addCardForm.style.display === 'none' || addCardForm.style.display === '') {
            // Show form & change button text
            addCardForm.style.display = 'block';
            this.textContent = 'Cancel';

            // Auto-focus first input
            const firstInput = addCardForm.querySelector('input[name="title"]');
            firstInput?.focus();
        } else {
            // Hide form & change button text back
            addCardForm.style.display = 'none';
            this.textContent = 'Add New Card';
            this.style.background = 'none';
            this.style.color = '';
            this.style.border = '2px dashed #aaa';

            // Clear form fields
            const inputs = addCardForm.querySelectorAll('input[type="text"], textarea');
            inputs.forEach(input => input.value = '');
        }
    });
});

// -----------------------
// Edit & Delete card logic
// -----------------------
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const title = btn.dataset.title;
        const content = btn.dataset.content;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-content').value = content;

        new bootstrap.Modal(document.getElementById('editCardModal')).show();
    });
});

document.getElementById('services_bgcolor')?.addEventListener('input', function () {
    document.querySelector('.servicetext.services').style.backgroundColor = this.value;
});

</script>
