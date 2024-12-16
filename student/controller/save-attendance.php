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

        $amTimeInStart = $event['am_time_in'];  // e.g., "07:00"
        $amTimeOut = $event['am_time_out'];    // e.g., "12:00"
        $pmTimeInStart = $event['pm_time_in']; // e.g., "13:00"
        $pmTimeOut = $event['pm_time_out'];    // e.g., "17:00"

        $studentId = $student['STUDENT_ID'];
        $currentTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');

        // Session boundaries
        $morningEnd = strtotime("{$currentDate} 12:00:00");
        $isMorning = strtotime($currentTime) < $morningEnd;

        if ($isMorning) {
            // Time-in period: 1 hour before to 1 hour 30 minutes after
            $scanStart = strtotime("{$currentDate} {$amTimeInStart} -1 hour");
            $lateStart = strtotime("{$currentDate} {$amTimeInStart} +1 minute");
            $scanEnd = strtotime("{$currentDate} {$amTimeInStart} +1 hour 30 minutes");

            // Time-out period: Event end time + 40 minutes
            $timeoutStart = strtotime("{$currentDate} {$amTimeOut}");
            $timeoutEnd = strtotime("{$currentDate} {$amTimeOut} +40 minutes");

            $session = 'AM';
        } else {
            // Time-in period: 1 hour after the event resumes
            $scanStart = strtotime("{$currentDate} {$pmTimeInStart}");
            $scanEnd = strtotime("{$currentDate} {$pmTimeInStart} +1 hour");

            // Time-out period: Event end time + 1 hour
            $timeoutStart = strtotime("{$currentDate} {$pmTimeOut}");
            $timeoutEnd = strtotime("{$currentDate} {$pmTimeOut} +1 hour");

            $session = 'PM';
        }

        $currentTimestamp = strtotime($currentTime);

        // Determine attendance type (Time-In or Time-Out)
        if ($currentTimestamp >= $scanStart && $currentTimestamp <= $scanEnd) {
            $type = 1; // Time-In
            $status = ($currentTimestamp >= $lateStart) ? 'Late' : 'On Time';
        } elseif ($currentTimestamp >= $timeoutStart && $currentTimestamp <= $timeoutEnd) {
            $type = 2; // Time-Out
            $status = 'On Time';
        } else {
            echo json_encode(['success' => false, 'message' => 'Attendance is not allowed outside the scheduled times.']);
            exit;
        }

        // Check for duplicate attendance
        $alreadyClocked = $attendanceRepository->hasClockedInOrOut($studentId, $eventId, $session, $type);
        if ($alreadyClocked) {
            echo json_encode(['success' => false, 'message' => 'Attendance already recorded for this session.']);
            exit;
        }

        // Save attendance
        $attendanceSaved = $attendanceRepository->addAttendance($studentId, $eventId, $currentTime, $session, $type, $status);
        if (!$attendanceSaved) {
            echo json_encode(['success' => false, 'message' => 'Failed to save attendance.']);
            exit;
        }

        // Send SMS notification
        $phoneNumber = $student['GUARDIAN_PHONE_NO'];
        $smsMessage = ($type === 1) 
            ? "Dear Parents/Guardians, This confirms your child's attendance at Philippine College of Northwestern Luzon. Time-In: {$currentTime}. Status: {$status}. Best regards, [PCNL]"
            : "Dear Parents/Guardians, This confirms your child's departure from the school event at PCNL. Time-Out: {$currentTime}. Best regards, [PCNL]";

        $smsSent = $sms->sendSMS($phoneNumber, $smsMessage);
        $smsNotificationRepository->addSMSNotification($phoneNumber, $studentId, $smsMessage);

        echo json_encode([
            'success' => true, 
            'attendance_saved' => $attendanceSaved, 
            'sms_sent' => $smsSent,
            'status' => $status
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid QR code or event ID data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>