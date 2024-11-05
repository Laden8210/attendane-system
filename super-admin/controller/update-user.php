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
if (empty($userTypeId) || !is_numeric($userTypeId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user type selection.']);
    exit;
}

// Proceed to update user if validation passes
$success = $userRepository->updateUser($userId, $courseId, $userTypeId, $firstName, $lastName, $middleName, $email);

if ($success) {
    echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
}
?>
