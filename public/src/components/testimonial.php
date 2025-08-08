<?php
include 'backend/config.php';

$keys = ['paragraph_test', 'test_title'];
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

//FOR TESTIMONIAL   
// $testimonial_query = "SELECT * FROM testimonials_table ORDER BY id DESC";
// $testimonial_result = $conn->prepare($testimonial_query);
// $testimonials = [];

// if ($testimonial_result && $testimonial_result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $testimonials[] = $rows;
//     }
// }
$testimonial_stmt = $conn->prepare("SELECT * FROM testimonials_table ORDER BY id DESC");
$testimonial_stmt->execute();
$result = $testimonial_stmt->get_result();

$testimonials = [];
while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}

?>
<?php if (isset($_SESSION['user_id'])): ?>
<div id="testimonial" class=""></div>
<?php endif; ?>
    <script src="../../public/main/scripts/data.js"></script>
<script>
    const testimonialDiv = document.getElementById('testimonial');
    testimonialDiv.innerHTML = ` 
    <div class="modal fade testimonialContent">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="backend/savecms.php" method="POST" enctype="multipart/form-data">
                        <textarea name="paragraph_test" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['paragraph_test'] ?? "What our Client Says"); ?></textarea>
                        <textarea name="test_title" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['test_title'] ?? "TESTIMONIAL"); ?></textarea>
                        <div id="edit-buttons" class="text-center modal-footer">
                            <button type="button" id="save_testimonial" class="btn btn-success mb-2">Save</button>
                            <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    <br><hr>
                    <!--INSERT TESTIMONIAL CARDS CRUD HERE-->
                    <h5 class="mt-4">Testimonial Cards</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Testimonial</th>
                                <th>Testifier Name</th>
                                <th>Role</th>
                                <th>Rating</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $test): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($test['test_content']); ?></td>
                                    <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                                    <td><?php echo htmlspecialchars($test['roles']); ?></td>
                                    <td><?php echo htmlspecialchars($test['stars']); ?> stars</td>

                                    <td class="d-flex justify-content-between align-items-center gap-1">
                                        <form action="backend/delete_testimonial.php" method="POST" class="d-inline">   
                                            <input type="hidden" name="id" value="<?php echo $test['id']; ?>">
                                            <button type="button" class="btn btn-danger my-auto delete-testimonial-btn" style="width:100px;">Delete</button>
                                        </form>
                                        <div class="d-flex">
                                        <button class="btn btn-secondary edit-btn-testimonial" 
                                            data-id="<?php echo $test['id']; ?>" 
                                            data-content="<?php echo htmlspecialchars($test['test_content'], ENT_QUOTES); ?>"
                                            data-name="<?php echo htmlspecialchars($test['test_name'], ENT_QUOTES); ?>"
                                            data-role="<?php echo htmlspecialchars($test['roles'], ENT_QUOTES); ?>"
                                            data-stars="<?php echo htmlspecialchars($test['stars'], ENT_QUOTES); ?>" style="width:100px;">
                                            Edit
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                                
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php include 'testimonial_edit_modal.php'; ?>
                    <div class="text-center">
                        <button id="showAddTestimonialForm" class="btn btn-success">
                            Add New Card
                        </button>
                    </div>
                    <hr>
                    <div id="addTestimonialForm" style="display: none;">
                        <h5>Add new testimonial</h5>
                        <form action="backend/add_testimonial.php" method="POST">
                            <textarea name="test_content" class="form-control mb-2" rows="3" placeholder="Testimonial Content" required></textarea>
                            <input type="text" name="test_name" class="form-control mb-2" placeholder="Name" required>
                            <input type="text" name="roles" class="form-control mb-2" placeholder="Role" required>
                            <input type="number" max="5" name="stars" placeholder="5">
                            <br>
                            
                            <button class="btn btn-primary float-end" type="submit">Add Testimonial</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="vh-80 mt-5">
        <div class="textimonial text-danger text-center my-4">
            <h5><?php echo htmlspecialchars($content['paragraph_test'] ?? "What our Client Says"); ?></h5>
            <h4 class="testimonial1 fw-bold display-5"><?php echo htmlspecialchars($content['test_title'] ?? "TESTIMONIAL"); ?></h4>
        </div>
        <div class="cardtest owl-carousel owl-theme justify-content-center mt-5 my-auto container">
        <?php foreach ($testimonials as $index => $test): ?>
            <div class="item text-center p-4 d-flex flex-column mt-5">
                <div class="img-area bg-light">
                    <p class="fw-bolder display-1 text-danger my-auto">"</p>
                </div>
                <p class="mb-3">"<?php echo htmlspecialchars($test['test_content']); ?>"</p>
                
                <div class="text-warning">
                    <?php
                        $stars = (int) $test['stars'];
                        echo str_repeat('★', $stars) . str_repeat('☆', 5 - $stars);
                    ?>
                </div><br>

                <div>
                    <strong><?php echo htmlspecialchars($test['test_name']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($test['roles']); ?></small><br>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="text-center">
                        <button type="button" class="btn btn-warning " onclick="toggleEditAll(this)" data-modal-target=".testimonialContent">Edit</button>
                    </div>
        <?php endif; ?>
        `;
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
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            960: {
                items: 3,
                nav: false
            }
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
    document.getElementById('showAddTestimonialForm').addEventListener('click', function () {
    const form = document.getElementById('addTestimonialForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
  
  
</script>

<script>
document.querySelectorAll('.delete-testimonial-btn').forEach(button => {
  button.addEventListener('click', function () {
    const form = this.closest('form');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This card will be permanently deleted!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Delete',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});

document.getElementById('save_testimonial').addEventListener('click', function () {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to save your changes?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, save it!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#6c757d'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('aboutus-form').submit();
    }
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

