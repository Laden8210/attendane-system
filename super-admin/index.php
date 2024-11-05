<?php

require_once '../repository/config.php';
require_once '../repository/StudentRepository.php';
require_once '../repository/UserRepository.php';
require_once '../repository/CourseRepository.php';



$studentRepository = new StudentRepository($conn);
$courseRepository = new CourseRepository($conn);
$userRepository = new UserRepository($conn);



$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

switch ($view) {
    case 'dashboard':
        $title = 'Dashboard';
        $content = '../content/super-admin/dashboard.php';
        break;

    case 'course':
        $title = 'Dashboard';
        $content = '../content/super-admin/course.php';
        break;

    case 'admin-list':
        $title = 'Dashboard';
        $content = '../content/super-admin/admin-list.php';
        break;


    default:
        $title = 'Dashboard';
        $content = '../content/super-admin/dashboard.php';
        break;
}

require_once '../template/super-admin.php';
