<link rel="stylesheet" href="../../../main/style/main.css">
<?php
include __DIR__ . '/../../backend/config.php';

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    if (!$stmt) {
        die("Delete SQL Error: " . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all messages
$stmt = $conn->prepare("SELECT id, name, email, message FROM messages ORDER BY id DESC");
if (!$stmt) {
    die("Fetch SQL Error: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <h1 class="my-3 text-secondary">Messages Management</h1>
<div class="table-responsive-sm rounded-3 overflow-hidden border shadow">
    <table class="table table-hover rounded-5">
        <thead class="table-secondary">   
            <tr>
                <th width="50" class="text-light py-3">ID</th>
                <th width="150" class="py-3 text-secondary">Name</th>
                <th width="200" class="py-3 text-secondary">Email</th>
                <th class="py-3 text-secondary">Message</th>
                <th width="120" class="py-3 text-center text-secondary">Action</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-secondary"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td style="max-width: 400px; white-space: pre-wrap;" class="w-auto"><?php echo htmlspecialchars($row['message']); ?></td>
                        <td class="text-center">
                            <form method="POST" class="my-auto">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button class="btn"><img src="../../../main/images/trash.svg" alt="" class="delete-button img-fluid mx-auto"></button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No messages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>