<?php
include 'backend/config.php';

$keys = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'phone_image'];
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
        <div>
            <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone_image'] ?? 'intro_img.png')?>" class="phone1 current-cms-img" data-cms-key="phone_image" alt="welcome image">
        </div>
        <div class="my-5 text-danger fs-5">

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Display Section -->
                <div id="all-display">
                    <h4 class="fw-bold display-5"><?php echo htmlspecialchars($content['welcome']); ?></h4>
                    <p class="textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph2']); ?></p>
                    <p class="textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph3']); ?></p>
                    <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".welcomeContent">Edit</button>
                </div>

                <!-- FORM -->
                <div class="modal fade welcomeContent" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit Content</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="all-form" method="POST" action="backend/savecms.php">
                            <textarea name="welcome" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['welcome']); ?></textarea>
                            <textarea name="paragraph2" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph2']); ?></textarea>
                            <textarea name="paragraph3" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph3']); ?></textarea>
                            <div>
                                <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone_image'] ?? 'intro_img.png')?>" class="phone1 current-cms-img" data-cms-key="phone_image" alt="">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="phone_image" accept="image/*">
                                <?php endif; ?>
                            </div>
                            <div id="edit-buttons" class="text-center modal-footer">
                                <button type="submit" class="btn btn-success mb-2">Save</button>
                                <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <h4 class="fw-bold display-5"><?php echo htmlspecialchars($content['welcome']); ?></h4>
                <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph2']); ?></p>
                <p class="desktop textstyle text-danger mb-4 fs-3"><?php echo htmlspecialchars($content['paragraph3']); ?></p>
            <?php endif; ?>

        </div>
    </div>
</section>
