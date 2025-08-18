<?php
include 'backend/config.php';

$keys = ['paragraph_test', 'test_title', 'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM testimonial WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}

$testimonial_stmt = $conn->prepare("SELECT * FROM testimonials_table ORDER BY id DESC");
$testimonial_stmt->execute();
$result = $testimonial_stmt->get_result();

$testimonials = [];
while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}
?>

<?php if (isset($_SESSION['user_id'])): ?>
<div id="testimonial"></div>
<?php endif; ?>

<script src="../../public/main/scripts/data.js"></script>
<script>
const testimonialDiv = document.getElementById('testimonial');

testimonialDiv.innerHTML = 
`
    <!-- Modal 1: Edit Title & Paragraph -->
    <div class="modal fade" id="testimonialTitleModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Testimonial Title & Paragraph</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <hr>  
                    <form action="backend/savecms.php" method="POST">
                         <div class="d-flex flex-column flex-md-row align-items-start gap-4">
                         <div style="min-width: 200px; width: 100%; max-width: 200px;">
                            <!-- Paragraph Color -->
<label class="form-label fw-bold text-secondary mb-3">Paragraph Font Color:</label>
<input type="text" id="test_paragraph_hex" 
    class="form-control text-uppercase mb-2" 
    maxlength="7" style="border-color: black;" 
    value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">

<input type="color" id="test_paragraph_color" 
    class="form-control form-control-color mb-4" 
    style="height: 64px; border-color: black; width: 100%;" 
    value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">

<input type="hidden" name="test_paragraph_color" id="test_paragraph_hidden"
    value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">



<!-- Title Font Color -->
<label class="form-label fw-bold text-secondary">Title Font Color:</label>
<input type="text" id="test_title_hex" 
    class="form-control text-uppercase mb-2" 
    maxlength="7" style="border-color: black;" 
    value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">

<input type="color" id="test_title_color" 
    class="form-control form-control-color mb-5" 
    style="height: 40px; border-color: black; width: 100%;" 
    value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">

<input type="hidden" name="test_title_color" id="test_title_hidden"
    value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">
                            </div>

                                <div class="flex-grow-1 w-100 ">
                                    <label class="form-label fw-bold text-secondary mb-3">Testimonials Paragraph:</label>
                                    <textarea name="paragraph_test" class="form-control border border-dark mb-4" rows="4"><?php echo htmlspecialchars($content['paragraph_test'] ?? "What our Client Says"); ?></textarea>
                                   
                                    <label class="form-label fw-bold text-secondary">Testimonials Title:</label>
                                    <textarea name="test_title" class="form-control mb-3 border border-dark" rows="3"><?php echo htmlspecialchars($content['test_title'] ?? "Testimonial"); ?></textarea>
                                </div>
                        </div>
                        <!-- Testimonials Border Color -->
<label class="form-label fw-bold text-secondary">Testimonials Border Color:</label>
<div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
    <input type="text" id="test_border_hex" 
        class="form-control text-uppercase" 
        maxlength="7" style="border-color: black; flex: 0 0 27%;" 
        value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">

    <input type="color" id="test_border_color" 
        class="form-control form-control-color" 
        style="height: 38px; border-color: black; width: 100%;" 
        value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">

    <input type="hidden" name="test_border_color" id="test_border_hidden"
        value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">
</div>



<!-- Testimonials Quotation Color -->
<label class="form-label fw-bold text-secondary mt-2">Testimonials Quotation Font Color:</label>
<div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
    <input type="text" id="test_quotation_hex" 
        class="form-control text-uppercase" 
        maxlength="7" style="border-color: black; flex: 0 0 27%;" 
        value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">

    <input type="color" id="test_quotation_color" 
        class="form-control form-control-color" 
        style="height: 38px; border-color: black; width: 100%;" 
        value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">

    <input type="hidden" name="test_quotation_color" id="test_quotation_hidden"
        value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">
</div>
                             <div class="text-center modal-footer d-flex flex-column flex-md-row justify-content-center gap-3">
                                <button type="submit" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
                                <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Manage Testimonials -->
    <div class="modal fade" id="testimonialManageModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                <div class="modal-header">
                    <h3 class="modal-title">Manage Testimonials</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                
                <div class="text-center">
                        <button id="showAddTestimonialForm" class="services-card w-75 p-3 mx-auto d-block rounded my-3 text-dark fw-bold" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: 2px dashed #aaa;">Add New Card</button>
                    </div>
                    <hr>
                    <div id="addTestimonialForm" class="mb-5" style="display: none;">
                        <h5 class="text-center">Add new testimonial</h5>
                        <form action="backend/add_testimonial.php" method="POST" class="w-75 mx-auto">
                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Content:</label>
                            <textarea name="test_content" class="form-control mb-2" rows="3" style="border-color: black;" placeholder="Testimonial Content" required></textarea>

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Name:</label>
                            <input type="text" name="test_name" class="form-control mb-2" style="border-color: black;" placeholder="Name" required>
                            
                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Role:</label>
                            <select name="roles" class="form-control mb-2" style="border-color: black;" required>
                                <option value="">-- Select Role --</option>
                                <option value="Driver">Driver</option>
                                <option value="User">User</option>
                            </select>

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Rating:</label>
                            <br>
                            <input type="number" max="5" name="stars" placeholder="5">
                            
                            <button class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto mt-3" style="border-color: black;" type="submit">Add Testimonial</button>
                        </form>
                    </div>
                       <div class="container">
  <div class="row g-4 justify-content-center">
    <?php foreach ($testimonials as $test): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="border border-dark text-center p-4 h-100 rounded" style="border-radius: 8px; display: flex; flex-direction: column; justify-content: space-between;">
          
          <!-- Testimonial Content -->
          <p class="fst-italic mb-3" style="max-height: auto; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">
            "<?php echo htmlspecialchars($test['test_content']); ?>"
          </p>

          <!-- Stars -->
          <p class="text-warning fs-5 mb-2">
            <?php echo str_repeat('★', (int)$test['stars']) . str_repeat('☆', 5 - (int)$test['stars']); ?>
          </p>

          <!-- Name + Role -->
          <p class="fw-bold mb-0"><?php echo htmlspecialchars($test['test_name']); ?></p>
          <p class="text-muted small mb-3"><?php echo htmlspecialchars($test['roles']); ?></p>

          <!-- Buttons -->
          <button class="contact_button px-4 py-2 rounded text-dark w-100 mb-2 edit-btn-testimonial" style="border-color: black;"
              data-id="<?php echo $test['id']; ?>"
              data-content="<?php echo htmlspecialchars($test['test_content'], ENT_QUOTES); ?>"
              data-name="<?php echo htmlspecialchars($test['test_name'], ENT_QUOTES); ?>"
              data-role="<?php echo htmlspecialchars($test['roles'], ENT_QUOTES); ?>"
              data-stars="<?php echo htmlspecialchars($test['stars'], ENT_QUOTES); ?>">
            Edit
          </button>

          <form action="backend/delete_testimonial.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $test['id']; ?>">
            <button type="button" class="contact_button px-4 py-2 rounded text-dark w-100 delete-testimonial-btn" style="border-color: black;">
              Delete
            </button>
          </form>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


                    <?php include 'testimonial_edit_modal.php'; ?>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- FRONTEND DISPLAY -->
    <div class="vh-80 mt-5">
        <div class="text-danger text-center my-4">
            <h5 style="color:<?php echo htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>"><?php echo htmlspecialchars($content['paragraph_test'] ?? "What our Client Says"); ?></h5>
            <h4 class="fw-bold display-5" style="color:<?php echo htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>"><?php echo htmlspecialchars($content['test_title'] ?? "TESTIMONIAL"); ?></h4>
        </div>
        
        <div class="cardtest owl-carousel owl-theme container mt-5">
        <?php foreach ($testimonials as $test): ?>
            <div class="item text-center p-4 d-flex flex-column mt-5" style="max-height: auto; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">
                <div class="img-area bg-light" >
                    <p class="fw-bolder display-1" style="color:<?php echo htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">"</p>
                </div>
                <p class="mb-3" >"<?php echo htmlspecialchars($test['test_content']); ?>"</p>
                <div class="text-warning">
                    <?php echo str_repeat('★', (int)$test['stars']) . str_repeat('☆', 5 - (int)$test['stars']); ?>
                </div><br>
                <div>
                    <strong><?php echo htmlspecialchars($test['test_name']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($test['roles']); ?></small>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mb-5 d-flex gap-3 w-75 mx-auto">
            <button type="button" class=" contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" data-bs-toggle="modal"  style="border-color: black;" data-bs-target="#testimonialTitleModal">
                Edit Title & Paragraph
            </button>
            <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-toggle="modal" data-bs-target="#testimonialManageModal">
                Manage Testimonials
            </button>
        </div>
        <?php endif; ?>
    </div>
`;
$(document).ready(function () {
    // Get border color from hidden input or fallback
    const borderColor = $("#test_border_color").val() || "#1a1a1a";

    // Initialize carousel
    $('.owl-carousel').owlCarousel({
        rtl: false,
        loop: true,
        margin: 50,
        center: true,
        smartSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            960: { items: 3 }
        }
    });

    // Add styling when carousel changes
    $(".owl-carousel").on("translated.owl.carousel", function () {
        $(this).find(".owl-item").css({
            "border": "5px solid transparent",
            "box-shadow": `0 4px 10px ${borderColor}`,
            "transform": "scale(1)",
            "transition": "none"
        });

        // Force reflow before applying to center item
        void this.offsetWidth;

        $(this).find(".owl-item.center").css({
            "border-width": "20px",
            "border-color": borderColor,
            "box-shadow": `0 4px 20px ${borderColor}`,
            "transform": "scale(1.05)",
            "transition": "border-width 0.3s ease, border-color 0.3s ease, transform 0.2s ease"
        });
    });
});


document.getElementById('showAddTestimonialForm').addEventListener('click', function () {
    const addCardForm = document.getElementById('addTestimonialForm');

    if (addCardForm.style.display === 'none' || addCardForm.style.display === '') {
        // Show form & change button text
        addCardForm.style.display = 'block';
        this.textContent = 'Cancel';
    } else {
        // Hide form & revert button text
        addCardForm.style.display = 'none';
        this.textContent = 'Add New Card';
    }
});

document.querySelectorAll('.edit-btn-testimonial').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const content = btn.dataset.content;
      const name = btn.dataset.name;
      const roles = btn.dataset.role;
      const stars = btn.dataset.stars;

      document.getElementById('edit-id-testimonial').value = id;
      document.getElementById('edit-content-testimonial').value = content;
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-roles').value = roles;
      document.getElementById('edit-rating').value = stars;

      new bootstrap.Modal(document.getElementById('editTestimonial')).show();
    });
  });

// When Manage Testimonials modal closes, reset the Add Testimonial form
document.getElementById('testimonialManageModal')
  .addEventListener('hidden.bs.modal', () => {
    const addFormWrapper = document.getElementById('addTestimonialForm');
    const form = addFormWrapper.querySelector('form');

    // Reset fields
    if (form) form.reset();

    // Hide the form wrapper again
    addFormWrapper.style.display = 'none';

    // Reset button text back to default
    const toggleBtn = document.getElementById('showAddTestimonialForm');
    if (toggleBtn) toggleBtn.textContent = 'Add New Card';
});

// Delete confirmation
document.querySelectorAll('.delete-testimonial-btn').forEach(button => {
  button.addEventListener('click', function () {
    const form = this.closest('form');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This testimonial will be deleted permanently!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
});

// Reset all forms inside modals when they are closed
document.querySelectorAll('.modal').forEach(modal => {
  modal.addEventListener('hidden.bs.modal', () => {
    const forms = modal.querySelectorAll('form');
    forms.forEach(form => form.reset());
  });
});


/* ✅ HEX <-> COLOR SYNC FUNCTION (Place at the very bottom) */
function syncColorInputs(hexInputId, colorInputId, hiddenInputId) {
  const hexInput = document.getElementById(hexInputId);
  const colorInput = document.getElementById(colorInputId);
  const hiddenInput = document.getElementById(hiddenInputId);

  if (!hexInput || !colorInput || !hiddenInput) return;

  // Hex → Color
  hexInput.addEventListener('input', () => {
    let val = hexInput.value.trim();
    if (!val.startsWith('#')) val = '#' + val;
    if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
      colorInput.value = val;
      hiddenInput.value = val;
    }
  });

  // Color → Hex
  colorInput.addEventListener('input', () => {
    hexInput.value = colorInput.value.toUpperCase();
    hiddenInput.value = colorInput.value;
  });
}

// Apply sync for all 4 pairs
syncColorInputs("test_paragraph_hex", "test_paragraph_color", "test_paragraph_hidden");
syncColorInputs("test_title_hex", "test_title_color", "test_title_hidden");
syncColorInputs("test_border_hex", "test_border_color", "test_border_hidden");
syncColorInputs("test_quotation_hex", "test_quotation_color", "test_quotation_hidden");

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
