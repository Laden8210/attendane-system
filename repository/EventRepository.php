<?php

class EventRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Method to add a new event
    public function addEvent($eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate, $course)
    {
        $sql = "INSERT INTO events (event_name, description, details, am_time_in, am_time_out, pm_time_in, pm_time_out, event_date, course_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate, $course);

        return $stmt->execute();
    }

    public function getAllEvents()
    {
        $sql = "SELECT * FROM events ORDER BY event_date ASC";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByCourse($course)
    {
        $sql = "SELECT * FROM events WHERE course_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $course);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventById($id)
    {
        $sql = "SELECT * FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function updateEvent($id, $eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate)
    {
        $sql = "UPDATE events SET event_name = ?, description = ?, details = ?, am_time_in = ?, am_time_out = ?, pm_time_in = ?, pm_time_out = ?, event_date = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $eventName, $description, $details, $amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut, $eventDate, $id);

        return $stmt->execute();
    }


    public function deleteEvent($id)
    {
        $sql = "DELETE FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
    
}
