<?php

require_once '../../repository/AttendanceRepository.php';
require_once '../../repository/config.php';

$attendanceRepository = new AttendanceRepository($conn);

$data = json_decode(file_get_contents('php://input'), true);
$eventId = $data['event_id'];
$searchTerm = $data['search'] ?? '';

// Get attendees based on search term
$attendees = $attendanceRepository->getAttendanceByEvent($eventId, $searchTerm);

if (!empty($attendees)) {
    echo json_encode(['success' => true, 'attendees' => $attendees]);
} else {
    echo json_encode(['success' => false, 'message' => 'No attendees found.']);
}
?>
