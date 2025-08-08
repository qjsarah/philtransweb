<?php
include 'backend/config.php'; // adjust path if needed

// Fetch background color from database
$contactBg = '#000066'; // fallback default
$result = $conn->query("SELECT content FROM cfs WHERE key_name = 'contact_bg'");
if ($result && $row = $result->fetch_assoc()) {
    $contactBg = $row['content'];
}
?>

<!-- Contact Section with Editable Background -->
<section class="contactbg contact text-center text-white" style="background-color: <?= htmlspecialchars($contactBg) ?>;">
    <div class="container py-5">
        <h5 class="display-5 fw-bold">Contact us</h5>
        <p></p>

        <!-- Background Color Editor (only visible if logged in) -->
        <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" action="backend/savecms.php" class="mb-4 d-flex justify-content-center align-items-center gap-2">
            <label for="contact_bg" class="form-label mb-0">Background Color:</label>
            <input type="color" id="contact_bg" name="contact_bg" value="<?= htmlspecialchars($contactBg) ?>" class="form-control form-control-color" style="width: 60px; height: 40px;">
            <button type="submit" class="btn btn-light btn-sm">Save</button>
        </form>
        <?php endif; ?>

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
                <img src="../../public/main/images/contact_section/message.png" alt="" class="icon-img">
            </div>
            <div class="contact_nav d-flex flex-column">
                <a href="">info@philtransinc.com</a>
                <a href="">+63 917 501 0018</a>
            </div>
        </div>

        <div class="iconcen py-4 text-center">
            <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
                <img src="../../public/main/images/contact_section/location.png" alt="" class="icon-img">
            </div>
            <p class="w-50 w-md-50 mx-auto">
                D-3 2F Plaza Victoria, Santo Rosario St., Sto Domingo, Angeles City 2009 Pampanga Philippines
            </p>
        </div>

        <div class="iconright py-4">
            <div class="contact_info d-flex justify-content-center align-items-center mx-auto mb-3">
                <img src="../../public/main/images/contact_section/web.png" alt="" class="icon-img">
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
