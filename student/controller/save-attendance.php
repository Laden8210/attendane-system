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
$smsNotificationRepository = new SMSNotificationRepository($conn);

$sms = new SMS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['qrCode']) && isset($data['event_id'])) {
        $qrCode = $data['qrCode'];
        $eventId = $data['event_id'];

        // Retrieve the student by QR code
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

        $studentId = $student['STUDENT_ID'];
        $currentTime = date('Y-m-d H:i:s');
        $currentHour = date('H');
        $session = ($currentHour < 12) ? 'AM' : 'PM'; 

        $eventStartTime = ($session === 'AM') ? $event['am_time_in'] : $event['pm_time_in'];
        $eventEndTime = ($session === 'AM') ? $event['am_time_out'] : $event['pm_time_out'];

  
        $type = 1;

        $timeInAllowed = (strtotime($currentTime) >= strtotime($eventStartTime)) && 
                         (strtotime($currentTime) <= strtotime($eventStartTime . ' +1 hour'));

        $timeOutAllowed = (strtotime($currentTime) >= strtotime($eventEndTime)) && 
                          (strtotime($currentTime) <= strtotime($eventEndTime . ' +30 minutes'));

      
        if ($timeInAllowed) {
            $type = 1; 
        } elseif ($timeOutAllowed) {
            $type = 2; 


            $hasClockedIn = $attendanceRepository->hasClockedIn($studentId, $eventId, $session);
            if (!$hasClockedIn) {
                echo json_encode(['success' => false, 'message' => 'You cannot clock out without first clocking in.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'You are outside the allowed time for this session.']);
            exit;
        }


        $alreadyClockedInOrOut = $attendanceRepository->hasClockedInOrOut($studentId, $eventId, $session, $type);
        if ($alreadyClockedInOrOut) {
            echo json_encode(['success' => false, 'message' => 'You have already clocked in/out for this session.']);
            exit;
        }


        $attendanceSaved = $attendanceRepository->addAttendance($studentId, $eventId, $currentTime, $session, $type);
        if (!$attendanceSaved) {
            echo json_encode(['success' => false, 'message' => 'Failed to save attendance.']);
            exit;
        }


        $phoneNumber = $student['GUARDIAN_PHONE_NO'];
        $smsMessage = "You have successfully checked in/out to the school event. Thank you for your participation!";
        $smsSent = $sms->sendSMS($phoneNumber, $smsMessage);
        $smsNotificationRepository->addSMSNotification($phoneNumber, $studentId, $smsMessage);


        echo json_encode(['success' => true, 'attendance_saved' => $attendanceSaved, 'sms_sent' => $smsSent]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid QR code or event ID data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
