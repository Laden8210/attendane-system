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

require_once 'repository/OfficerRepository.php';
require_once 'repository/UserRepository.php';
require_once 'repository/CourseRepository.php';

require_once 'repository/config.php';
require_once 'repository/CourseRepository.php';

$userRepository = new UserRepository($conn);
$officerRepository = new OfficerRepository($conn);

$usersExist = $userRepository->readAll();
if (empty($usersExist)) {
    $view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : '';

    if($view == ''){
        $title = 'Welcome';
        $content = 'content/landing-page/welcome.php';
    }else{
        $title = 'Create Account';
        $content = 'content/landing-page/create-account.php';
    }


   

} else {
    $courseRepository = new CourseRepository($conn);
    $view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : '';

    switch ($view) {
        case 'welcome':
            $title = 'Welcome';
            $content = 'content/landing-page/welcome.php';
            break;
        case 'course':
            $title = 'Course';
            $content = 'content/landing-page/course-list.php';
            break;

        case 'login':
            $title = 'Login';
            $content = 'content/landing-page/login.php';
            break;


        default:
            $title = 'Welcome';
            $content = 'content/landing-page/welcome.php';
            break;
    }
}


require_once 'template/app.php';
