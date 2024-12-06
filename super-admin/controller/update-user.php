<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php'; 
$userRepository = new UserRepository($conn);

// Retrieve and sanitize input
$userId = isset($_POST['user_id']) ? htmlspecialchars(trim($_POST['user_id'])) : null;
$firstName = isset($_POST['first_name']) ? htmlspecialchars(trim($_POST['first_name'])) : null;
$lastName = isset($_POST['last_name']) ? htmlspecialchars(trim($_POST['last_name'])) : null;
$middleName = isset($_POST['middle_name']) ? htmlspecialchars(trim($_POST['middle_name'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$courseId = isset($_POST['course']) ? htmlspecialchars(trim($_POST['course'])) : null;
$userTypeId = isset($_POST['user_type']) ? htmlspecialchars(trim($_POST['user_type'])) : null;

// Validation
if (empty($userId) || !is_numeric($userId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
    exit;
}
if (empty($firstName)) {
    echo json_encode(['status' => 'error', 'message' => 'First name is required.']);
    exit;
}
if (empty($lastName)) {
    echo json_encode(['status' => 'error', 'message' => 'Last name is required.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}
if (empty($courseId) || !is_numeric($courseId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid course selection.']);
    exit;
}

// Initialize avatar variable
$file_name = null;

if (isset($_FILES['edit-avatar']) && $_FILES['edit-avatar']['error'] === UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($_FILES['edit-avatar']['tmp_name']);
    $file_size = $_FILES['edit-avatar']['size'];

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid avatar file type. Only JPG, PNG, and GIF are allowed.']);
        exit;
    }

    $upload_dir = '../../resource/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = uniqid() . '-' . basename($_FILES['edit-avatar']['name']);
    $avatar_file_path = $upload_dir . $file_name;

    if (!move_uploaded_file($_FILES['edit-avatar']['tmp_name'], $avatar_file_path)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload avatar.']);
        exit;
    }
}

$success = $userRepository->updateUser($userId, $courseId, $userTypeId, $firstName, $lastName, $middleName, $email, $file_name);

if ($success) {
    echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
}
?>
