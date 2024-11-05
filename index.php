<?php

session_start();
if (isset($_SESSION['user_type_id']) || isset($_SESSION['officer_id'])) {

    if (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 0) {
        header('Location: super-admin/');
        exit;
    } elseif (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1) {
        header('Location: admin/');
        exit;
    } elseif (isset($_SESSION['officer_id'])) {

        header('Location: student/');
        exit;
    }
}

$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

require_once 'repository/config.php';
require_once 'repository/CourseRepository.php';

$courseRepository = new CourseRepository($conn);

switch ($view) {
    case 'welcome':
        $title = 'Welcome';
        $content = 'content/landing-page/welcome.php';
        break;
    case 'course':
        $title = 'Course';
        $content = 'content/landing-page/course-list.php';
        break;
    case 'create-account':
        $title = 'Create Account';
        $content = 'content/landing-page/create-account.php';
        break;
    
    case 'login':
        $title = 'Login';   
        $content = 'content/landing-page/login.php';
        break;  

    default:
        $title = 'Welcome';
        $content = 'content/landing-page//welcome.php';
        break;
}

require_once 'template/app.php';
