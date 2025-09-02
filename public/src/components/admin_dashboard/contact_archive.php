<?php
include __DIR__ . '/../../backend/config.php';

$keys = ['location_img', 'contact_img', 'web_img'];
$placeholders = implode(',', array_fill(0, count($keys), '?')); // ?,?,?,?

$sql = "SELECT * FROM contact_archive WHERE key_name IN ($placeholders) ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

// bind_param requires types string. We can do str_repeat('s', count($keys))
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

?>

<h2>Archived Images for Contact Section </h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Preview</th>
        <th>File Name</th>
        <th>Uploaded On</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td>
            <img src="/philtrans/philtransweb/public/main/images/contact_section/archive/<?php echo htmlspecialchars($row['file_name']); ?>" width="100">
        </td>
        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
             <form method="POST" action="../../backend/admin_dashboard/restore_contact.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="key_name" value="<?php echo $row['key_name']; ?>">
                <button type="submit">Restore</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
