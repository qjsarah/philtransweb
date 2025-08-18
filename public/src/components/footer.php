<?php
include 'backend/config.php';

$keys = ['footer_copyright', 'footer_credits'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM footer WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<footer class="text-center text-white  ">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mb-5">
            <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".footerContent">Edit</button>
        </div>
    <?php endif; ?>
    <div class="w-75  d-flex flex-column flex-md-row text-center justify-content-md-between mx-auto">
        
        <p><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></p>
        <p><?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By BB 88 Advertising and Digital Solutions Inc."); ?><a href="https://bb88advertising.com/" target="_blank" 
            style="text-decoration: none; color: inherit;" 
            onmouseover="this.style.color='#a1a1a1ff'" 
            onmouseout="this.style.color='inherit'">
            BB 88 Advertising and Digital Solutions Inc.</a></p>
    </div>

    <!-- Modal -->
    <div class="modal fade footerContent" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <form id="all-form" method="POST" action="backend/savecms.php">
                    <textarea name="footer_copyright" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></textarea>
                    <textarea name="footer_credits" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By BB 88 Advertising and Digital Solutions Inc."); ?></textarea>
                    <div class="text-center modal-footer">
                        <button type="button" class="save-button btn btn-success mb-2">Save</button>
                        <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</footer>
