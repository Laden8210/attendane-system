<?php
require_once '../../repository/config.php';
require_once '../../repository/EventRepository.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id'])) {
        $eventId = $_POST['event_id'];
        $eventName = $_POST['event_name'];
        $description = $_POST['description'];
        $details = $_POST['details'];
        $amTimeIn = $_POST['am_time_in'];
        $amTimeOut = $_POST['am_time_out'];
        $pmTimeIn = $_POST['pm_time_in'];
        $pmTimeOut = $_POST['pm_time_out'];
        $eventDate = $_POST['date'];

        $eventRepository = new EventRepository($conn);

        $isUpdated = $eventRepository->updateEvent($eventId, $eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate);

        if ($isUpdated) {
            echo json_encode(['status' => 'success', 'message' => 'Event updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update event.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event ID is missing.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
