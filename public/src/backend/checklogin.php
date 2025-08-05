<?php
require("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password, account_activation_hash FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        exit;
    }

    $stmt->bind_result($userId, $hashedPassword, $activationHash);
    $stmt->fetch();

    // Pang check kung activated na ang account
    if ($activationHash !== null) {
            echo json_encode(['status' => 'error', 'message' => 'Account not activated.']);
            exit;
        }

    $stmt->bind_result($userId, $hashedPassword, $activation_token);
    $stmt->fetch();


    session_start();
    $_SESSION['user_id'] = $userId; 

    echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
}

$stmt->close();
$conn->close();
?>
