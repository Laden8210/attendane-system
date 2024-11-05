<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';


$userRepository = new UserRepository($conn);

$userId = $_GET['user_id'];

$user = $userRepository->readUser($userId);
echo json_encode($user);
?>
