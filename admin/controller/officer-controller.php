<?php
require_once '../../repository/config.php';
require_once '../../repository/OfficerRepository.php';
require_once '../../repository/UserRepository.php';
session_start();   
$action = $_GET['action'];
$officerRepository = new OfficerRepository($conn);


if ($action === 'list') {
    $userRepositoy = new UserRepository($conn);

    $user = $userRepositoy->readUser($_SESSION['user_id']);
    $officers = $officerRepository->getOfficersByCourse($user['course_id']);
    echo json_encode(['officers' => $officers]);
}

if ($action === 'create') {
    $studentId = $_POST['student_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $success = $officerRepository->createOfficer($studentId, $username, $password);
    echo json_encode(['success' => $success]);
}

if ($action === 'edit') {
    $officerId = $_GET['officer_id'];
    $officer = $officerRepository->getOfficerById($officerId);
    echo json_encode($officer);
}

if ($action === 'update') {
    $officerId = $_POST['officer_id'];
    $studentId = $_POST['student_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    $success = $officerRepository->updateOfficer($officerId, $studentId, $username, $password);
    echo json_encode(['success' => $success]);
}

if ($action === 'delete') {
    $officerId = $_GET['officer_id'];
    $success = $officerRepository->deleteOfficer($officerId);
    echo json_encode(['success' => $success]);
}
?>
