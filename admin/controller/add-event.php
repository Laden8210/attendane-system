<?php
require_once '../../repository/config.php';
require_once '../../repository/EventRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $eventRepository = new EventRepository($conn);

    $eventName = trim($_POST['event_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $amTimeIn = $_POST['am_time_in'] ?? '';
    $amTimeOut = $_POST['am_time_out'] ?? '';
    $pmTimeIn = $_POST['pm_time_in'] ?? '';
    $pmTimeOut = $_POST['pm_time_out'] ?? '';
    $eventDate = $_POST['event_date'] ?? '';


    if (empty($eventName)) {
        echo json_encode(['status' => 'error', 'message' => 'Event name is required.']);
        exit;
    }

    if (empty($description)) {
        echo json_encode(['status' => 'error', 'message' => 'Description is required.']);
        exit;
    }


    if (empty($details)) {
        echo json_encode(['status' => 'error', 'message' => 'Details are required.']);
        exit;
    }


    if (empty($amTimeIn) || empty($amTimeOut)) {
        echo json_encode(['status' => 'error', 'message' => 'Both AM Time In and AM Time Out are required.']);
        exit;
    }

    if ($amTimeIn >= $amTimeOut) {
        echo json_encode(['status' => 'error', 'message' => 'AM Time In should be earlier than AM Time Out.']);
        exit;
    }

    if (empty($pmTimeIn) || empty($pmTimeOut)) {
        echo json_encode(['status' => 'error', 'message' => 'Both PM Time In and PM Time Out are required.']);
        exit;
    }

    if ($pmTimeIn >= $pmTimeOut) {
        echo json_encode(['status' => 'error', 'message' => 'PM Time In should be earlier than PM Time Out.']);
        exit;
    }

    if (empty($eventDate)) {
        echo json_encode(['status' => 'error', 'message' => 'Event date is required.']);
        exit;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventDate)) { 
        echo json_encode(['status' => 'error', 'message' => 'Invalid date format. Use YYYY-MM-DD.']);
        exit;
    }

    $success = $eventRepository->addEvent($eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate);

    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Event added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add event.']);
    }
}
?>
