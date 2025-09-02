<?php
include '../config.php'; 

if (isset($_POST['id'], $_POST['key_name'])) {
    $id  = (int)$_POST['id'];
    $key = $_POST['key_name'];

    // Fetch archive record to restore
    $stmt = $conn->prepare("SELECT file_name, original_name FROM about_archive WHERE id=? AND key_name=?");
    $stmt->bind_param("is", $id, $key);
    $stmt->execute();
    $stmt->bind_result($fileName, $originalName);
    $stmt->fetch();
    $stmt->close();

    if ($fileName) {
        $rootPath   = dirname(__DIR__, 4); 
        $archiveDir = $rootPath . "/public/main/images/about_section/archive/";
        $uploadDir  = $rootPath . "/public/main/images/about_section/";

        // Step 1: Backup current file before overwriting
        $stmt = $conn->prepare("SELECT content FROM aboutus WHERE key_name=?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $stmt->bind_result($currentFile);
        $stmt->fetch();
        $stmt->close();

        if ($currentFile) {
            $currentPath = $uploadDir . $currentFile;
            if (file_exists($currentPath)) {
                $archivedName = time() . "_old_" . rand(1000,9999) . "." . pathinfo($currentFile, PATHINFO_EXTENSION);
                if (copy($currentPath, $archiveDir . $archivedName)) {
                    // Insert old file into archive table
                    $stmt = $conn->prepare("INSERT INTO about_archive (key_name, file_name, original_name) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $key, $archivedName, $currentFile);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        // Step 2: Restore chosen archive file
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = time() . "_" . rand(1000,9999) . "." . $ext;

        $archivePath = $archiveDir . $fileName;
        $restorePath = $uploadDir . $newFileName;

        if (file_exists($archivePath)) {
            if (copy($archivePath, $restorePath)) {
                // Update main table
                $stmt = $conn->prepare("UPDATE aboutus SET content=? WHERE key_name=?");
                $stmt->bind_param("ss", $newFileName, $key);
                $stmt->execute();
                $stmt->close();

                // ✅ Step 3: Remove the restored entry from archive table
                $stmt = $conn->prepare("DELETE FROM about_archive WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();

                // ✅ Step 4: Remove the file from archive folder
                if (file_exists($archivePath)) {
                    unlink($archivePath);
                }
            }
        }
    }
}

header("Location: ../../components/admin_dashboard/download_about.php");
exit;