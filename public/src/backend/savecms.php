<?php
session_start();
include 'config.php';

// Text fields
$fields = ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'aboutus', 'PTAS', 'paragraph4', 'mission', 'vision', 'paragraph5', 'paragraph6', 'mission_image', 'vision_image', 'ads1', 'ads2', 'person1', 'phone_image', 'services_image', 'service_title', 'ads5', 'ads6', 'download_bg_color', 'aboutus_bgcolor', 'contact_bg', 'services_bgcolor', 'paragraph_test', 'test_title'];

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php");
//         exit;
//     }
// }

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php#about");
//         exit;
//     }
// }

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php#missionvission");
//         exit;
//     }
// }

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php#missionvission");
//         exit;
//     }
// }

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE card_table SET content = ? WHERE title = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php#services");
//         exit;
//     }
// }

// foreach ($fields as $field) {
//     if (isset($_POST[$field])) {
//         $content = $_POST[$field];
//         $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
//         $stmt->bind_param("ss", $content, $field);
//         $stmt->execute();
//         $stmt->close();
//         header("Location: ../index.php#testimonial");
//         exit;
//     }
// }
foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $content = $_POST[$field];

        // Decide which table and section to update based on $field
        if (in_array($field, ['download1', 'paragraph1', 'welcome', 'paragraph2', 'paragraph3', 'download_bg_color'])) {
            $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#';
        }

        if (in_array($field, ['welcome', 'paragraph2', 'paragraph3'])) {
            $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#welcome';
        }
        if (in_array($field, ['aboutus', 'PTAS', 'paragraph4', 'aboutus_bgcolor'])) {
            $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#about';
        }

        if (in_array($field, ['mission', 'vision', 'paragraph5', 'paragraph6'])) {
            $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#missionvission';
        }

        if (in_array($field, ['service_title', 'services_bgcolor'])) {
            $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#services';
        }

        if (in_array($field, ['paragraph_test', 'test_title'])) {
            $stmt = $conn->prepare("UPDATE testimonial SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#testimonial';
        }
        // ✅ Update CFS table fields
        if (in_array($field, ['contact_bg'])) {
            $content = $_POST[$field];
            $stmt = $conn->prepare("UPDATE cfs SET content = ? WHERE key_name = ?");
            $stmt->bind_param("ss", $content, $field);
            $stmt->execute();
            $stmt->close();
            $redirectSection = '#contact';
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
        $maxSize = 2 * 1024 * 1024;

        $fileType = $_FILES['cms_image']['type'];
        $fileSize = $_FILES['cms_image']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $filename = time() . '_' . basename($_FILES['cms_image']['name']);
            $targetPath = $uploadDir . $filename;
            $dbPath = $relativePath . $filename;

            if (move_uploaded_file($_FILES['cms_image']['tmp_name'], $targetPath)) {
                $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            $redirectSection = '';
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
                $stmt = $conn->prepare("UPDATE missionvision SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            $redirectSection = '#missionvission';
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
                $stmt = $conn->prepare("UPDATE aboutus SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            $redirectSection = '#about';
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
                $stmt = $conn->prepare("UPDATE services SET content = ? WHERE key_name = ?");
                $stmt->bind_param("ss", $dbPath, $cmsKey);
                $stmt->execute();
                $stmt->close();
            $redirectSection = '#services';
            }
        }
    }
}


if ($redirectSection) {
    header("Location: ../index.php{$redirectSection}");
    exit;
}