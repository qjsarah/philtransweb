<!-- Archive Modal -->
<?php include __DIR__ . '/../../../src/backend/config.php'; ?>

<?php 
$stmt = $conn->prepare("SELECT * FROM about_archive WHERE key_name='tricycle' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<h1>About Section</h1>
<table class="table table-bordered">
  <tr>
    <th>Preview</th>
    <th>File Name</th>
    <th>Date</th>
    <th>Action</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><img src="../../../main/images/about_section/archive/<?php echo $row['file_name']; ?>" width="100"></td>
    <td><?php echo htmlspecialchars($row['original_name']); ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>
      <form method="POST" action="../../backend/admin_dashboard/recover_about.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="key_name" value="<?php echo $row['key_name']; ?>">
        <button type="submit" class="btn btn-success btn-sm" onclick="restoreDownload(<?= $row['id'] ?>)">Restore</button>
      </form>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<script>
function restoreDownload(id, key) {
    if (confirm("Are you sure you want to restore this file?")) {
        $.post("../../backend/admin_dashboard/recover_about.php", { id: id, key_name: key }, function(response) {
            if (response.trim() === "success") {
                alert("Restored successfully!");
                location.reload();
            } else {
                alert("Restore failed: " + response);
            }
        });
    }
}
</script>
