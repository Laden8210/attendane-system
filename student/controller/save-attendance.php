<?php

date_default_timezone_set('Asia/Manila');
require_once '../../function/SMS.php';
require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';
require_once '../../repository/AttendanceRepository.php'; 
require_once '../../repository/EventRepository.php'; 
require_once '../../repository/SMSNotificationRepository.php'; 

$studentRepository = new StudentRepository($conn);
$attendanceRepository = new AttendanceRepository($conn);
$eventRepository = new EventRepository($conn); 
$smsNotificationRepository = new SMSNotificationRepository($conn);

$sms = new SMS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['qrCode']) && isset($data['event_id'])) {
        $qrCode = $data['qrCode'];
        $eventId = $data['event_id'];

        $student = $studentRepository->readByStudentNumber($qrCode);
        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found.']);
            exit;
        }

        $event = $eventRepository->getEventById($eventId);
        if (!$event) {
            echo json_encode(['success' => false, 'message' => 'Event not found.']);
            exit;
        }


        $amTimeInStart = $event['am_time_in'];   
        $amTimeOut = $event['am_time_out'];
        $pmTimeInStart = $event['pm_time_in'];     
        $pmTimeOut = $event['pm_time_out'];       

        $studentId = $student['STUDENT_ID'];
        $currentTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentHour = date('H');
        $session = ($currentHour < 12) ? 'AM' : 'PM';


        if ($session === 'AM') {
            $scanStart = date('Y-m-d H:i:s', strtotime("{$currentDate} {$amTimeInStart} -1 hour"));
            $scanEnd = "{$currentDate} {$amTimeInStart}";
            $timeoutStart = date('Y-m-d H:i:s', strtotime("{$currentDate} {$amTimeOut} +30 minutes"));
        } else {
            $scanStart = date('Y-m-d H:i:s', strtotime("{$currentDate} {$pmTimeInStart} -1 hour"));
            $scanEnd = "{$currentDate} {$pmTimeInStart}";
            $timeoutStart = date('Y-m-d H:i:s', strtotime("{$currentDate} {$pmTimeOut} +30 minutes"));
        }


        if ($currentTime >= $scanStart && $currentTime <= $scanEnd) {
   
            $type = 1; // Time In
        } elseif ($currentTime >= $timeoutStart) {
  
            $type = 2; // Time Out
        } else {
    
            echo json_encode(['success' => false, 'message' => 'Attendance is only allowed during the scheduled times.']);
            exit;
        }


        $alreadyClockedInOrOut = $attendanceRepository->hasClockedInOrOut($studentId, $eventId, $session, $type);
        if ($alreadyClockedInOrOut) {
            echo json_encode(['success' => false, 'message' => 'You have already recorded this type of attendance for this session.']);
            exit;
        }

   
        $attendanceSaved = $attendanceRepository->addAttendance($studentId, $eventId, $currentTime, $session, $type);
        if (!$attendanceSaved) {
            echo json_encode(['success' => false, 'message' => 'Failed to save attendance.']);
            exit;
        }

        $phoneNumber = $student['GUARDIAN_PHONE_NO'];
        $smsMessage = ($type === 1) 
            ? "You have successfully recorded your Time In for the event. Thank you for your participation!" 
            : "You have successfully recorded your Time Out for the event. Thank you for your participation!";
        
        $smsSent = $sms->sendSMS($phoneNumber, $smsMessage);
        
        $smsNotificationRepository->addSMSNotification($phoneNumber, $studentId, $smsMessage);

        echo json_encode(['success' => true, 'attendance_saved' => $attendanceSaved, 'sms_sent' => $smsSent]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid QR code or event ID data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

?>
