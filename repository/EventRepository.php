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
        $stmt->bind_param("i", $course);
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

    public function getEventByCourseAndSearch($courseId, $search = '') {
        $sql = "SELECT * FROM events 
                WHERE course_id = ? 
                AND (event_name LIKE ? OR description LIKE ? OR details LIKE ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }
        $likeSearch = '%' . $search . '%';
        $stmt->bind_param('isss', $courseId, $likeSearch, $likeSearch, $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
}
