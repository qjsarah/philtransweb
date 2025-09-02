<?php
include '../config.php';

if (isset($_POST['id'], $_POST['key_name'])) {
    $id  = (int)$_POST['id'];
    $key = $_POST['key_name'];

    // Get file from archive
    $stmt = $conn->prepare("SELECT file_name FROM contact_archive WHERE id=? AND key_name=?");
    $stmt->bind_param("is", $id, $key);
    $stmt->execute();
    $stmt->bind_result($restoreFile);
    $stmt->fetch();
    $stmt->close();

    if ($restoreFile) {
        $rootPath   = dirname(__DIR__, 4);
        $archiveDir = $rootPath . "/public/main/images/contact_section/archive/";
        $uploadDir  = $rootPath . "/public/main/images/contact_section/";

        $archivePath = $archiveDir . $restoreFile;
        $restorePath = $uploadDir . $restoreFile;

        // Fetch current about image
        $stmt = $conn->prepare("SELECT content FROM contact WHERE key_name=?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $stmt->bind_result($currentFile);
        $stmt->fetch();
        $stmt->close();

        // Save current file into archive before overwriting
        if ($currentFile) {
            $currentPath = $uploadDir . $currentFile;
            if (file_exists($currentPath)) {
                copy($currentPath, $archiveDir . $currentFile);
                $stmt = $conn->prepare("INSERT INTO contact_archive (key_name, file_name) VALUES (?, ?)");
                $stmt->bind_param("ss", $key, $currentFile);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Restore selected file
        if (file_exists($archivePath)) {
            copy($archivePath, $restorePath);

            $stmt = $conn->prepare("UPDATE contact SET content=? WHERE key_name=?");
            $stmt->bind_param("ss", $restoreFile, $key);
            $stmt->execute();
            $stmt->close();

            // Delete restored record from archive
            $stmt = $conn->prepare("DELETE FROM contact_archive WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            unlink($archivePath);
        }
    }
}

header("Location: ../../components/admin_dashboard/contact_archive.php");
exit;
