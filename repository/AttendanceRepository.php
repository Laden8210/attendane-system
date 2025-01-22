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
        $stmt->bind_param("iissss", $studentId, $eventId, $attendanceTime, $session, $type, $status);
        return $stmt->execute();
    }

    
    public function getAttendanceByEvent($eventId, $searchTerm = null)
    {
        if ($searchTerm) {
            $sql = "SELECT
                        a.student_id,
                        s.STUDENT_NUMBER,
                        CONCAT(s.FIRST_NAME, ' ', s.LAST_NAME) AS full_name,
                        c.COURSE_NAME,
                        c.YEAR,
                        s.BLOCK,
                        
                        -- Morning Attendance
                        MAX(CASE 
                            WHEN a.session = 'am' AND a.type = 1 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS morning_time_in,
                        
                        MAX(CASE 
                            WHEN a.session = 'am' AND a.type = 2 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS morning_time_out,
                        
                        -- Afternoon Attendance
                        MAX(CASE 
                            WHEN a.session = 'pm' AND a.type = 1 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS afternoon_time_in,
                        
                        MAX(CASE 
                            WHEN a.session = 'pm' AND a.type = 2 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS afternoon_time_out,
                        
                        -- Status
                        MAX(a.status) AS status
                    FROM
                        attendance a
                    JOIN
                        students s ON a.student_id = s.STUDENT_ID
                    JOIN
                        course c ON s.COURSE = c.ID
                    WHERE
                        a.event_id = ? 
                        AND (s.FIRST_NAME LIKE ? OR s.LAST_NAME LIKE ?)
                    GROUP BY
                        a.student_id,
                        a.event_id
                    ORDER BY
                        s.STUDENT_NUMBER ASC";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Database query preparation failed: " . $this->conn->error);
            }
            $searchTerm = "%" . $searchTerm . "%";
            $stmt->bind_param("iss", $eventId, $searchTerm, $searchTerm);
        } else {
            $sql = "SELECT
                        a.student_id,
                        s.STUDENT_NUMBER,
                          CONCAT(s.FIRST_NAME, ' ', s.LAST_NAME) AS full_name,
                        c.COURSE_NAME,
                        S.YEAR,
                        s.BLOCK,
                        
                        -- Morning Attendance
                        MAX(CASE 
                            WHEN a.session = 'am' AND a.type = 1 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS morning_time_in,
                        
                        MAX(CASE 
                            WHEN a.session = 'am' AND a.type = 2 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS morning_time_out,
                        
                        -- Afternoon Attendance
                        MAX(CASE 
                            WHEN a.session = 'pm' AND a.type = 1 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS afternoon_time_in,
                        
                        MAX(CASE 
                            WHEN a.session = 'pm' AND a.type = 2 THEN a.attendance_time 
                            ELSE NULL 
                        END) AS afternoon_time_out,
                        
                        -- Status
                        MAX(a.status) AS status
                    FROM
                        attendance a
                    JOIN
                        students s ON a.student_id = s.STUDENT_ID
                    JOIN
                        course c ON s.COURSE = c.ID
                    WHERE
                        a.event_id = ?
                    GROUP BY
                        a.student_id,
                        a.event_id
                    ORDER BY
                        s.STUDENT_NUMBER ASC";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Database query preparation failed: " . $this->conn->error);
            }
            $stmt->bind_param("i", $eventId);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Fetching results failed: " . $stmt->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
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
