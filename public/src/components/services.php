<?php
include 'backend/config.php';

$keys = ['services_image', 'service_title', 'services_bgcolor'];
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

<section class="servicetext services pb-5" style="background-color: <?php echo htmlspecialchars($content['services_bgcolor'] ?? '#000000'); ?>;">

    <?php if (isset($_SESSION['user_id'])): ?>
        <h4 class="text-white text-center pt-5 display-5 fw-bold"><?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?></h4>
        <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png')?>" alt="Service Image" class="bgservice w-75 img-fluid py-3 mx-auto d-block current-cms-img" data-cms-key="services_image">
        
        <?php foreach ($cards as $index => $card): ?>
            <div class="card<?php echo $index + 1; ?> services-card w-75 p-3 mx-auto d-block text-white rounded my-3">
                <h3><?php echo strtoupper(htmlspecialchars($card['title'])); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($card['content'])); ?></p>
            </div>
        <?php endforeach; ?>

        <div class="text-center">
            <button type="button" class="btn btn-warning mt-3 ad1" onclick="toggleEditAll(this)" data-modal-target=".serviceContent">Edit</button>
        </div>

        <div class="modal fade serviceContent" tabindex="-1" id="serviceModal">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Content</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <form id="all-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
                            <textarea name="service_title" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?></textarea>

                            <div>
                                <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png'); ?>" alt="Service Image" class="bgservice w-75 img-fluid py-3 mx-auto d-block current-cms-img">
                                <input type="file" name="services_image" class="form-control mb-2 cms-image-input" data-cms-key="services_image" accept="image/*">
                            </div>

                           

                            <div id="edit-buttons" class="text-center modal-footer">
                                <button type="submit" class="btn btn-success mb-2">Save</button>
                                <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>

                        <hr>
                        <!-- CRUD TABLE START -->
                            <h5 class="mt-4">Service Cards</h5>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th style="width: 160px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cards as $card): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($card['title']); ?></td>
                                            <td><?php echo htmlspecialchars($card['content']); ?></td>
                                            <td class="d-flex justify-content-between align-items-center gap-1">
                                                <form action="backend/delete_card.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?php echo $card['id']; ?>">
                                                    <button class="d-flex btn btn-danger  mx-auto my-auto" style="width:100px;">Delete</button>
                                                </form>
                                                <div class="d-flex mb-3">
                                                    <button class="btn btn-secondary edit-btn" 
                                                        data-id="<?php echo $card['id']; ?>" 
                                                        data-title="<?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?>" 
                                                        data-content="<?php echo htmlspecialchars($card['content'], ENT_QUOTES); ?>" style="width:100px;">
                                                        Edit
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php
                            include 'service_edit_modal.php';
                            ?>
                            <div class="text-center">
                                <button id="showAddCardForm" class="btn btn-success">
                                    Add New Card
                                </button>
                            </div>
           

                        <div id="addCardForm" style="display: none;">
                            <hr>
                            <h5>Add New Card</h5>
                            <form action="backend/add_card.php" method="POST">
                                <input type="text" name="title" class="form-control mb-2" placeholder="Card Title" required>
                                <textarea name="content" class="form-control mb-2" rows="3" placeholder="Card Description" required></textarea>
                                <button class="btn btn-primary" type="submit">Add Card</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <h4 class="text-white text-center pt-5 display-5 fw-bold"><?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?></h4>
        <img src="../main/images/services_section/<?php echo htmlspecialchars($content['services_image'] ?? 'Service_img.png')?>" alt="Service Image" class="bgservice w-75 img-fluid py-3 mx-auto d-block current-cms-img">
        
        <?php foreach ($cards as $index => $card): ?>
            <div class="card<?php echo $index + 1; ?> services-card w-75 p-3 mx-auto d-block text-white rounded my-3">
                <h3><?php echo strtoupper(htmlspecialchars($card['title'])); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($card['content'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</section>

<script>
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

document.getElementById('showAddCardForm').addEventListener('click', function () {
    const form = document.getElementById('addCardForm');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
});

document.getElementById('services_bgcolor')?.addEventListener('input', function () {
    document.querySelector('.servicetext.services').style.backgroundColor = this.value;
});
</script>