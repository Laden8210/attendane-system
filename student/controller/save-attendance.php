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

        // Lookup student
        $student = $studentRepository->readByStudentNumber($qrCode);
        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found.']);
            exit;
        }

        // Lookup event
        $event = $eventRepository->getEventById($eventId);
        if (!$event) {
            echo json_encode(['success' => false, 'message' => 'Event not found.']);
            exit;
        }

        // Fetch time data from the event
        $amTimeIn      = $event['am_time_in'];   // e.g. "07:00"
        $amTimeOut     = $event['am_time_out'];  // e.g. "12:00"
        $pmTimeIn      = $event['pm_time_in'];   // e.g. "13:00"
        $pmTimeOut     = $event['pm_time_out'];  // e.g. "17:00"

        // Current time data
        $currentTime       = date('Y-m-d H:i:s');
        $currentTimestamp  = strtotime($currentTime);
        $currentDate       = date('Y-m-d');

        // Build timestamps for AM session
        $amTimeInTs        = strtotime("{$currentDate} {$amTimeIn}");
        $amTimeOutTs       = strtotime("{$currentDate} {$amTimeOut}");
        // Time-In can be done 30 mins before up to 30 mins after
        $amTimeInStart     = $amTimeInTs - (30 * 60);  // 30 mins before
        $amTimeInEnd       = $amTimeInTs + (30 * 60);  // 30 mins after
        // Time-Out can be done 30 mins before up to 30 mins after
        $amTimeOutStart    = $amTimeOutTs - (30 * 60);
        $amTimeOutEnd      = $amTimeOutTs + (30 * 60);

        // Build timestamps for PM session
        $pmTimeInTs        = strtotime("{$currentDate} {$pmTimeIn}");
        $pmTimeOutTs       = strtotime("{$currentDate} {$pmTimeOut}");
        // Time-In can be done 30 mins before up to 30 mins after
        $pmTimeInStart     = $pmTimeInTs - (30 * 60);
        $pmTimeInEnd       = $pmTimeInTs + (30 * 60);
        // Time-Out can be done 30 mins before up to 30 mins after
        $pmTimeOutStart    = $pmTimeOutTs - (30 * 60);
        $pmTimeOutEnd      = $pmTimeOutTs + (30 * 60);

        // Determine which session (AM or PM) we're in, based on extended windows
        // If within AM windows
        if ($currentTimestamp >= $amTimeInStart && $currentTimestamp <= $amTimeOutEnd) {
            $session = 'AM';

            // Check if it's Time-In or Time-Out range
            if ($currentTimestamp >= $amTimeInStart && $currentTimestamp <= $amTimeInEnd) {
                // Time-In
                $type = 1;
                // Mark as late if scanning at or after the official start time
                $status = ($currentTimestamp >= $amTimeInTs) ? 'Late' : 'On Time';
            }
            elseif ($currentTimestamp >= $amTimeOutStart && $currentTimestamp <= $amTimeOutEnd) {
                // Time-Out
                $type   = 2;
                $status = 'On Time';
            }
            else {
                // Not in valid AM window
                echo json_encode(['success' => false, 'message' => 'Not in a valid AM Time-In or Time-Out window.']);
                exit;
            }
        }
        // Else if within PM windows
        elseif ($currentTimestamp >= $pmTimeInStart && $currentTimestamp <= $pmTimeOutEnd) {
            $session = 'PM';

            // Check if it's Time-In or Time-Out range
            if ($currentTimestamp >= $pmTimeInStart && $currentTimestamp <= $pmTimeInEnd) {
                // Time-In
                $type = 1;
                $status = ($currentTimestamp >= $pmTimeInTs) ? 'Late' : 'On Time';
            }
            elseif ($currentTimestamp >= $pmTimeOutStart && $currentTimestamp <= $pmTimeOutEnd) {
                // Time-Out
                $type   = 2;
                $status = 'On Time';
            }
            else {
                // Not in valid PM window
                echo json_encode(['success' => false, 'message' => 'Not in a valid PM Time-In or Time-Out window.']);
                exit;
            }
        }
        else {
            // Outside both AM and PM extended windows
            echo json_encode(['success' => false, 'message' => 'Attendance is not allowed outside the scheduled windows.']);
            exit;
        }

        // Check for duplicate attendance (already Time-In or Time-Out for that session)
        $studentId = $student['STUDENT_ID'];
        $alreadyClocked = $attendanceRepository->hasClockedInOrOut($studentId, $eventId, $session, $type);
        if ($alreadyClocked) {
            echo json_encode(['success' => false, 'message' => 'Attendance already recorded for this session.']);
            exit;
        }

        // Record attendance
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

        // Attempt to send the SMS (implement your SMS->sendSMS logic as needed)
        $smsSent = $sms->sendSMS($phoneNumber, $smsMessage);

        // Log the SMS in your notifications table
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
