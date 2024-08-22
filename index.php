<?php
$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

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
