<?php
require_once '../../repository/config.php';
require_once '../../repository/EventRepository.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $eventRepository = new EventRepository($conn);

    $event = $eventRepository->getEventById($eventId);

    if ($event) {
        echo json_encode(['status' => 'success', 'event' => $event]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID is missing.']);
}
