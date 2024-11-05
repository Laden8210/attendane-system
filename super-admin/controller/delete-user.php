<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';
$userRepository = new UserRepository($conn);


$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['user_id'];


$success = $userRepository->deleteUser($userId);


if ($success) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
