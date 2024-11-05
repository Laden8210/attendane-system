<?php

require_once '../../repository/StudentRepository.php'; 
require_once '../../repository/config.php'; 

$studentRepository = new StudentRepository($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'list') {
        $students = $studentRepository->readAll();
        echo json_encode(['status' => 'success', 'students' => $students]);
        exit;
    }
}
?>
