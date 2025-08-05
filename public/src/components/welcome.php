<?php
include 'backend/config.php';

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3'];
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

<section class="welcome mt-5">
    <div class="mt-5 pt-5 d-flex flex-column flex-lg-row justify-content-start gap-5 mx-3">
        <img src="../../public/main/images/intro_section/welcome_img.png" class="phone1" alt="">
        <div class="my-5 text-danger fs-5">

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Display Section -->
                <div id="all-display">
                    <h4 class="fw-bold display-5"><?php echo htmlspecialchars($content['welcome']); ?></h4>
                    <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph2']); ?></p>
                    <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph3']); ?></p>
                    <button type="button" class="btn btn-warning mb-3" onclick="toggleAllEdit()">Edit All</button>
                </div>

                <!-- Edit Section -->
                <form id="all-form" method="POST" action="backend/savecms.php" style="display: none;">
                    <textarea name="welcome" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['welcome']); ?></textarea>

                    <textarea name="paragraph2" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph2']); ?></textarea>

                    <textarea name="paragraph3" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph3']); ?></textarea>

                    <button type="submit" class="btn btn-success mb-2">Save Changes</button>
                    <button type="button" class="btn btn-secondary mb-2" onclick="toggleAllEdit()">Cancel</button>
                </form>

                <script>
                    function toggleAllEdit() {
                        const display = document.getElementById('all-display');
                        const form = document.getElementById('all-form');
                        const isEditing = form.style.display === 'block';
                        display.style.display = isEditing ? 'block' : 'none';
                        form.style.display = isEditing ? 'none' : 'block';
                    }
                </script>

            <?php else: ?>
                <!-- Guest View -->
                <h4 class="fw-bold display-5"><?php echo htmlspecialchars($content['welcome']); ?></h4>
                <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph2']); ?></p>
                <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph3']); ?></p>
            <?php endif; ?>

        </div>
    </div>
</section>
