<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';

header('Content-Type: application/json');

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRepository = new UserRepository($conn);
    $data = json_decode(file_get_contents('php://input'), true);

    $search = isset($data['search']) ? htmlspecialchars($data['search']) : '';

    $userID = $_SESSION['user_id'];

    if (!empty($search)) {
        $users = $userRepository->searchUsers($search);
    } else {
        $users = $userRepository->readAll();
    }

    // Filter out the current user
    $filteredUsers = array_filter($users, function ($user) use ($userID) {
        return $user['user_id'] != $userID;
    });

    if (!empty($filteredUsers)) {
        echo json_encode(['status' => 'success', 'users' => array_values($filteredUsers)]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No users found']);
    }
}
?>
