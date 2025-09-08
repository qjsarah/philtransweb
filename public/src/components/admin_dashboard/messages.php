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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <div class="container">
        <h2 class="mb-4">Messages Management</h2>

        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td style="max-width: 400px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this message permanently?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
