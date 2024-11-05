<?php
require_once '../../repository/config.php'; // Ensure this path is correct
require_once '../../repository/EventRepository.php';

$eventRepository = new EventRepository($conn);

// Fetch all events
$events = $eventRepository->getAllEvents(); // Implement this method to fetch all events

// Return the events as JSON
header('Content-Type: application/json');
echo json_encode($events);
?>
