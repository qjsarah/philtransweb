<link rel="stylesheet" href="../../../main/style/main.css">
<?php
include __DIR__ . '/../../backend/config.php';

$key = 'services_image'; // the key used in services table

$stmt = $conn->prepare("SELECT * FROM services_archive WHERE key_name = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $key);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container text-secondary">
    <h1 class="my-3">Archived Images for Services Section</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-auto p-3 shadow">
                    <img src="/philtransweb/public/main/images/services_section/archive/<?php echo htmlspecialchars($row['file_name']); ?>" 
                        class="card-img-top" 
                        alt="Archived Image">

                    <div class="card-body">
                        <p class="card-text">
                            <small class="text-muted">Uploaded On: <?php echo $row['created_at']; ?></small>
                        </p>
                    </div>

                    <div class="text-center">
                        <form method="POST" action="../../backend/admin_dashboard/restore_services.php" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="key_name" value="<?php echo $row['key_name']; ?>">
                            <button type="button" class="form-control btn btn-secondary border-none restore-button py-2">↺</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-secondary text-light w-100 d-flex align-items-center justify-content-center" style="height: 450px;">
                <p class="mb-0">No archived images found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="../../../main/scripts/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/philtransweb2/public/main/scripts/swal_archive.js"></script>
