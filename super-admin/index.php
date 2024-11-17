<?php

require_once '../repository/config.php';
require_once '../repository/StudentRepository.php';
require_once '../repository/UserRepository.php';
require_once '../repository/CourseRepository.php';
if (isset($_SESSION['officer_id'])) {
    header('Location: ../student/');
    exit;
}
if (isset($_SESSION['user_type_id'])) {

    if (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1) {
        header('Location: ../admin/');
        exit;
    } else {
        header('Location: ../index.php?view=login'); 
        exit;
    }
}

session_start();
$studentRepository = new StudentRepository($conn);
$courseRepository = new CourseRepository($conn);
$userRepository = new UserRepository($conn);

$user = $userRepository->readUser($_SESSION['user_id']);



$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

switch ($view) {
    case 'dashboard':
        $title = 'Dashboard';
        $content = '../content/super-admin/dashboard.php';
        break;

    case 'course':
        $title = 'Course';
        $content = '../content/super-admin/course.php';
        break;

    case 'admin-list':
        $title = 'Admin';
        $content = '../content/super-admin/admin-list.php';
        break;


    default:
        $title = 'Dashboard';
        $content = '../content/super-admin/dashboard.php';
        break;
}

require_once '../template/super-admin.php';
