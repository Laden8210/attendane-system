<?php
require_once '../../repository/config.php';
require_once '../../repository/EventRepository.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    

    if (isset($data['id']) && !empty($data['id'])) {
        $eventId = intval($data['id']);
        $eventRepository = new EventRepository($conn);
        
        $result = $eventRepository->deleteEvent($eventId);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Event deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete event.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event ID is missing or invalid.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
