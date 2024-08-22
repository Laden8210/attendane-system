<?php
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
    default:
        $title = 'Dashboard';
        $content = '../content/admin/dashboard.php';
        break;
}

require_once '../template/admin.php';
