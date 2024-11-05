<?php

require_once '../repository/config.php';
require_once '../repository/StudentRepository.php';

require_once '../repository/EventRepository.php';
require_once '../repository/SMSNotificationRepository.php';

$smsNotificationRepository = new SMSNotificationRepository($conn);
$studentRepository = new StudentRepository($conn);

$eventRepository = new EventRepository($conn);
$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

switch ($view) {
    case 'dashboard':
        $title = 'Dashboard';
        $content = '../content/admin/dashboard.php';
        break;
    case 'student-list':
        $title = 'Student List';
        $content = '../content/admin/student-list.php';
        break;

    case 'officer-list':
        $title = "Officer Account";
        $content = "../content/admin/officer-list.php";
        break;
    case 'sms':
        $title = "SMS Notification";
        $content = "../content/admin/sms-list.php";
        break;
    case 'event-list':
        $title = "Event List";
        $content = "../content/admin/event-list.php";
        break;
    case 'course':
        $title = "Course";
        $content = "../content/admin/course.php";
        break;
    default:
        $title = 'Dashboard';
        $content = '../content/admin/dashboard.php';
        break;
}

require_once '../template/admin.php';
