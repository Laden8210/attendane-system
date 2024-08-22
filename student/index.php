<?php
$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

switch ($view) {
    case 'welcome':
        $title = 'Welcome';
        $content = '../content/student/main.php';
        break;
    case 'event-details':
        $title = 'Event Details';
        $content = '../content/student/event-details.php';
        break;

    case 'scanner':
        $title = "Student Scanner";
        $content = "../content/student/scanner.php";
        break;
    case 'student-info':
        $title = "Student Information";
        $content = "../content/student/student-info.php";
        break;
    default:
        $title = 'Welcome';
        $content = '../content/student/main.php';
        break;
}

require_once '../template/app.php';
