<?php
require_once 'repository/config.php';
require_once 'repository/UserRepository.php';

$userRepository = new UserRepository($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $middleName = $_POST['middle_name'] ?? null;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    // Validate password match
    if ($password !== $passwordConfirm) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }


    $avatarPath = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $avatarFileName = basename($_FILES['avatar']['name']);
        $targetFilePath = 'resource/uploads/' . $avatarFileName;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFilePath)) {
            $avatarPath = $targetFilePath;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload avatar.']);
            exit;
        }
    }


    $userTypeId = 0; 
    $created = $userRepository->createUser(null, $userTypeId, $firstName, $lastName, $middleName, $email, $password, $avatarFileName);

    if ($created) {
        echo json_encode(['success' => true, 'message' => 'Account created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create account.']);
    }
}
?>
