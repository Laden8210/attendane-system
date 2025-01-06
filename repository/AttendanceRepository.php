<?php

class AttendanceRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function addAttendance($studentId, $eventId, $attendanceTime, $session, $type, $status)
    {
        $sql = "INSERT INTO attendance (student_id, event_id, attendance_time, session, type, status)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisss", $studentId, $eventId, $attendanceTime, $session, $type, $status);
        return $stmt->execute();
    }

    
    public function getAttendanceByEvent($eventId, $searchTerm = null)
    {
        if ($searchTerm) {
            $sql = "SELECT 
                        *,
                        GROUP_CONCAT(CONCAT(attendance.session, ' - ', IF(attendance.type = 1, 'Time In', 'Time Out'), ' at ', attendance.attendance_time) SEPARATOR '\n') AS attendance_details
                    FROM attendance
                    JOIN students ON attendance.student_id = students.STUDENT_ID
                    JOIN course ON students.COURSE = course.ID
                    WHERE attendance.event_id = ? AND (students.FIRST_NAME LIKE ? OR students.LAST_NAME LIKE ?)
                    GROUP BY students.STUDENT_ID, attendance.attendance_id
                    ORDER BY attendance.attendance_time IS NULL, attendance.attendance_time ASC";
            $searchTerm = "%" . $searchTerm . "%";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $eventId, $searchTerm, $searchTerm);
        } else {
            $sql = "SELECT 
                        *,
                        GROUP_CONCAT(CONCAT(attendance.session, ' - ', IF(attendance.type = 1, 'Time In', 'Time Out'), ' at ', attendance.attendance_time) SEPARATOR '\n') AS attendance_details
                    FROM attendance
                    JOIN students ON attendance.student_id = students.STUDENT_ID
                    JOIN course ON students.COURSE = course.ID
                    WHERE attendance.event_id = ?
                    GROUP BY students.STUDENT_ID, attendance.attendance_id
                    ORDER BY attendance.attendance_time IS NULL, attendance.attendance_time ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $eventId);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    


    public function getAttendanceByStudent($studentId)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function updateAttendance($attendanceId, $attendanceTime, $type)
    {
        $sql = "UPDATE attendance SET attendance_time = ?, type = ? WHERE attendance_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $attendanceTime, $type, $attendanceId);
        return $stmt->execute();
    }

    public function deleteAttendance($attendanceId)
    {
        $sql = "DELETE FROM attendance WHERE attendance_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $attendanceId);
        return $stmt->execute();
    }


    public function hasClockedIn($studentId, $eventId, $session)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ? AND event_id = ? AND session = ? AND type = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $studentId, $eventId, $session);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function hasClockedInOrOut($studentId, $eventId, $session, $type)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ? AND event_id = ? AND session = ? AND type = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisi", $studentId, $eventId, $session, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
