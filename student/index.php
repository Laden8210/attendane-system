<?php
$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

require_once '../repository/config.php';
require_once '../repository/StudentRepository.php';

require_once '../repository/EventRepository.php';
require_once '../repository/AttendanceRepository.php';

if (!isset($_SESSION['officer_id'])) {
    echo '<script>';
    if (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 0) {
        echo 'window.location.href = "../super-admin/";';
    } elseif (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1) {
        echo 'window.location.href = "../admin/";';
    } else {
        echo 'window.location.href = "../index.php?view=login";';
    }
    echo '</script>';
    exit;
}

$eventRepository = new EventRepository($conn);
$attendanceRepository = new AttendanceRepository($conn);
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
