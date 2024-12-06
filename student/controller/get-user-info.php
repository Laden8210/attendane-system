<?php

require_once '../../function/SMS.php';
require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';
require_once '../../repository/AttendanceRepository.php'; 
require_once '../../repository/EventRepository.php'; 
require_once '../../repository/SMSNotificationRepository.php'; 

$studentRepository = new StudentRepository($conn);
$attendanceRepository = new AttendanceRepository($conn);
$eventRepository = new EventRepository($conn);

header('Content-Type: application/json');

// Get parameters from the request
$qrCode = $_GET['qrCode'] ?? '';
$eventId = $_GET['event_id'] ?? '';

if (!$qrCode || !$eventId) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request parameters.'
    ]);
    exit;
}


$student = $studentRepository->readByStudentNumber($qrCode);

if (!$student) {
    echo json_encode([
        'success' => false,
        'message' => 'Student not found.',
        'student_id' => $qrCode
    ]);
    exit;
}

if($_GET['course'] != $student['COURSE']){
    echo json_encode([
        'success' => false,
        'message' => 'Student does not belong to the department.',
        'student_id' => $qrCode
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => [
        'LAST_NAME' => $student['LAST_NAME'],
        'FIRST_NAME' => $student['FIRST_NAME'],
        'COURSE' => $student['COURSE'],
        'STUDENT_ID' => $student['STUDENT_NUMBER'],
        'YEAR' => $student['YEAR'],
        'CONTACT_NUMBER' => $student['GUARDIAN_PHONE_NO'],
        'COURSE' => $student['COURSE_NAME'],
        'AVATAR' => $student['AVATAR']
    ]
]);
?>
