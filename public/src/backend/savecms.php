<?php
session_start();
include 'config.php';

// Text fields
$fields = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'aboutus', 'PTAS', 'paragraph4', 'mission_title', 'vision_title', 'mission_content', 'vision_content', 'mission_image', 'vision_image', 'ads1', 'ads2', 'person1', 'phone_image', 'services_image', 'service_title', 'ads5', 'ads6', 'download_bg_color', 'aboutus_bgcolor', 'contact_bg', 'services_bg_color', 'services_title_color' ,'card_title_color','card_desc_color', 'paragraph_test', 'test_title', 'download_title_color', 'download_desc_color', 'welcome_title_color','welcome_desc_color', 'aboutus_title_color','aboutus_sub_color', 'aboutus_desc_color', 'mission_title_color', 'mission_content_color', 'vision_title_color', 'vision_content_color', 'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color', 'contact_title', 'email', 'number', 'location', 'phone4_img', 'location_img', 'contact_img', 'web_img', 'footer_copyright', 'footer_credits', 'contact_title_color', 'contact_font_color', 'footer_bg_color', 'footer_font_color'];


foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $content = $_POST[$field];

        if (in_array($field, [
                'download1', 'paragraph1', 'paragraph2', 'paragraph3', 
                'download_bg_color', 'download_title_color', 'download_desc_color'
            ])) {
                $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $content, $field);
                $stmt->execute();
                $stmt->close();
                $redirectSection = '#';
            }


        if (in_array($field, ['welcome', 'paragraph2', 'paragraph3', 'welcome_title_color','welcome_desc_color'])) {
            $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#welcome';
        }
        if (in_array($field, ['aboutus', 'PTAS', 'paragraph4', 'aboutus_bgcolor', 'aboutus_title_color', 'aboutus_sub_color', 'aboutus_desc_color'])) {
            $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#about';
        }

        if (in_array($field, ['mission_title', 'vision_title', 'mission_content', 'vision_content', 'mission_title_color', 'mission_content_color','vision_title_color', 'vision_content_color'])) {
            $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#missionvission';
        }

        if (in_array($field, ['service_title', 'services_bg_color', 'services_title_color','card_title_color','card_desc_color'])) {
            $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#services';
        }

        if (in_array($field, ['paragraph_test', 'test_title', 'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color'])) {
            $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#testimonial';
        }
        // ✅ Update CFS table fields
        if (in_array($field, ['contact_bg', 'contact_title', 'email', 'number', 'location', 'contact_title_color', 'contact_font_color'])) {
            $content = $_POST[$field];
            $stmt = $conn->prepare("UPDATE contact SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#contact';
        }

        if (in_array($field, ['footer_copyright', 'footer_credits', 'footer_bg_color', 'footer_font_color'])) {
            $stmt = $conn->prepare("UPDATE footer SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#footer';
        }
    }
}


// Download Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['ads1', 'ads2', 'person1', 'phone_image'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'ads1' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
            'ads2' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
            'person1' => ['dir' => '../../main/images/download_section/', 'path' => ''],
            'phone_image' => ['dir' => '../../main/images/intro_section/', 'path' => ''],
        ];

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {

                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM download WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO download_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}


// Mission and Vision Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['mission_image', 'vision_image', 'ads3', 'ads4'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'mission_image' => ['dir' => '../../main/images/mission_and_vission_section/', 'path' => ''],
            'vision_image' => ['dir' => '../../main/images/mission_and_vission_section/', 'path' => ''],
            'ads3' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
            'ads4' => ['dir' => '../../main/images/ads_section/', 'path' => '']
        ];

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                  // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM missionvision WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO missionvision_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// About Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['tricycle'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'tricycle' => ['dir' => '../../main/images/about_section/', 'path' => '']
        ];

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM aboutus WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO aboutus_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Services Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['services_image', 'ads5', 'ads6'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
        $allowedKeys = [
            'services_image' => ['dir' => '../../main/images/services_section/', 'path' => ''],
            'ads5' => ['dir' => '../../main/images/ads_section/', 'path' => ''],
            'ads6' => ['dir' => '../../main/images/ads_section/', 'path' => '']
        ];

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
               // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM services WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO services_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Contact Section
if (isset($_POST['cms_key']) && in_array($_POST['cms_key'], ['phone4_img', 'location_img', 'contact_img', 'web_img'])) {
    $cmsKey = $_POST['cms_key'];

    if (isset($_FILES['cms_image']) && $_FILES['cms_image']['error'] === UPLOAD_ERR_OK) {
       $allowedKeys = [
        'location_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        'contact_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        'web_img' => ['dir' => '../../main/images/contact_section/', 'path' => ''],
        ];
        

        if (!array_key_exists($cmsKey, $allowedKeys)) {
            http_response_code(400);
            exit('Invalid CMS key.');
        }

        $uploadDir = $allowedKeys[$cmsKey]['dir'];
        $relativePath = $allowedKeys[$cmsKey]['path'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
               // ✅ Step 1: Fetch current image
                $stmt = $conn->prepare("SELECT content FROM contact WHERE key_name=?");
                $stmt->bind_param("s", $cmsKey);
                $stmt->execute();
                $stmt->bind_result($oldFile);
                $stmt->fetch();
                $stmt->close();

                if ($oldFile) {
                    $archiveDir = $uploadDir . "archive/";
                    if (!is_dir($archiveDir)) {
                        mkdir($archiveDir, 0777, true);
                    }

                    $oldPath = $uploadDir . basename($oldFile);
                    $archivedName = time() . "_archived_" . basename($oldFile);
                    $archivedPath = $archiveDir . $archivedName;

                    if (file_exists($oldPath)) {
                        if (rename($oldPath, $archivedPath)) {
                            // ✅ Step 2: Insert into archive DB
                            $stmt = $conn->prepare("INSERT INTO contact_archive (key_name, file_name) VALUES (?, ?)");
                            $stmt->bind_param("ss", $cmsKey, $archivedName);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }

                // ✅ Step 3: Update with new image
                $stmt = $conn->prepare("UPDATE contact SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}


if ($redirectSection) {
    header("Location: ../index.php{$redirectSection}");
    exit;
}