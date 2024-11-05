<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRepository = new UserRepository($conn);
    $data = json_decode(file_get_contents('php://input'), true);

    $search = isset($data['search']) ? htmlspecialchars($data['search']) : '';

    // Search query
    if (!empty($search)) {
        $users = $userRepository->searchUsers($search);
    } else {
        $users = $userRepository->readAll();
    }

    if (!empty($users)) {
        echo json_encode(['status' => 'success', 'users' => $users]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No users found']);
    }
}
?>
