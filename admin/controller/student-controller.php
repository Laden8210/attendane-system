<?php

require_once '../../repository/StudentRepository.php'; 
require_once '../../repository/config.php'; 
require_once '../../repository/UserRepository.php'; 
$studentRepository = new StudentRepository($conn);
$userRepository = new UserRepository($conn);
session_start();

$user = $userRepository->readUser($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'list') {
        $students = $studentRepository->readByCourse($user['course_id']);
        echo json_encode(['status' => 'success', 'students' => $students]);
        exit;
    }
}
?>
