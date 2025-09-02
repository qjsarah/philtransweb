<?php
include '../config.php';

if (isset($_POST['id'], $_POST['key_name'])) {
    $id  = (int)$_POST['id'];
    $key = $_POST['key_name'];

    // ✅ Step 1: Fetch archive record (image to restore)
    $stmt = $conn->prepare("SELECT file_name FROM download_archive WHERE id=? AND key_name=?");
    $stmt->bind_param("is", $id, $key);
    $stmt->execute();
    $stmt->bind_result($fileName);
    $stmt->fetch();
    $stmt->close();

    if ($fileName) {
        // Define folders
        $rootPath   = dirname(__DIR__, 4);
        $archiveDir = $rootPath . "/public/main/images/intro_section/archive/";
        $uploadDir  = $rootPath . "/public/main/images/intro_section/";

        $archivePath = $archiveDir . $fileName;
        $restorePath = $uploadDir . $fileName;

        // ✅ Step 2: Fetch current image in `intro`
        $stmt = $conn->prepare("SELECT content FROM download WHERE key_name=?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $stmt->bind_result($currentFile);
        $stmt->fetch();
        $stmt->close();

        // ✅ Step 3: Move current image into archive before restoring
        if ($currentFile) {
            $currentPath = $uploadDir . basename($currentFile);

            if (file_exists($currentPath)) {
                $archivedName = time() . "_archived_" . basename($currentFile);
                $archivedPath = $archiveDir . $archivedName;

                // Move to archive
                if (rename($currentPath, $archivedPath)) {
                    // Insert into archive table
                    $stmt = $conn->prepare("INSERT INTO download_archive (key_name, file_name) VALUES (?, ?)");
                    $stmt->bind_param("ss", $key, $archivedName);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        // ✅ Step 4: Restore selected image
        if (file_exists($archivePath)) {
            if (copy($archivePath, $restorePath)) {
                $dbPath = $fileName; // only filename stored

                // Update intro table
                $stmt = $conn->prepare("UPDATE download SET content=? WHERE key_name=?");
                $stmt->bind_param("ss", $dbPath, $key);
                $stmt->execute();
                $stmt->close();

                // ❌ DO NOT delete record permanently
                // Instead: optionally mark as restored or keep it (so history stays)
                // If you want to remove only the restored one:
                $stmt = $conn->prepare("DELETE FROM download_archive WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();

                // We also do not unlink archive file → so history is preserved
            }
        }
    }
}

header("Location: ../../components/admin_dashboard/intro_archive.php");
exit;
