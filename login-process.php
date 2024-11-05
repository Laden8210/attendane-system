<?php


require_once 'repository/config.php';
require_once 'repository/UserRepository.php';

$userRepository = new UserRepository($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $user = $userRepository->getUserByUsernameOrEmail($username);

    if ($user && $password == $user['password']) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type_id'] = $user['user_type_id'];

        echo json_encode(['success' => true, 'message' => 'Login successful!', 'user_type_id' => $user['user_type_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }
}
?>
