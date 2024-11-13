<?php

session_start();
require_once '../repository/config.php';
require_once '../repository/StudentRepository.php';

require_once '../repository/EventRepository.php';
require_once '../repository/SMSNotificationRepository.php';
require_once '../repository/CourseRepository.php';
require_once '../repository/UserRepository.php';
require_once '../repository/OfficerRepository.php'; 

$smsNotificationRepository = new SMSNotificationRepository($conn);
$studentRepository = new StudentRepository($conn);
$courseRepository = new CourseRepository($conn);

$userRepository = new UserRepository($conn);

$officerRepository = new OfficerRepository($conn);
$eventRepository = new EventRepository($conn);
$view = isset($_GET['view']) ? htmlspecialchars($_GET['view']) : 'home';

if (isset($_SESSION['officer_id'])) {
    header('Location: ../student/');
    exit;
}
if (isset($_SESSION['user_type_id'])) {

    if ($_SESSION['user_type_id'] == 0) {
        header('Location: ../super-admin/');
        exit;
   
    } elseif($_SESSION['user_type_id'] != 1) {
        header('Location: ../index.php?view=login'); 
        exit;
    }
}

 $user = $userRepository->readUser($_SESSION['user_id']);
$course = $courseRepository->getCourseById($user['course_id']);

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
    case 'report':
        $title = "Report";
        $content = "../content/admin/report.php";
        break;
    default:
        $title = 'Dashboard';
        $content = '../content/admin/dashboard.php';
        break;
}

require_once '../template/admin.php';
