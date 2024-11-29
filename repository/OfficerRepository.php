<?php

class OfficerRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function createOfficer($studentId, $username, $password)
    {
        $sql = "INSERT INTO officers (STUDENT_ID, USERNAME, PASSWORD) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("iss", $studentId, $username, $password);
        $success = $stmt->execute();

        $stmt->close();
        return $success;
    }

    public function getAllOfficers()
    {
        $sql = "SELECT officers.OFFICER_ID, officers.USERNAME, officers.PASSWORD, students.FIRST_NAME, students.LAST_NAME, students.COURSE, students.AVATAR
                FROM officers 
                JOIN students ON officers.STUDENT_ID = students.STUDENT_ID ";

        $result = $this->conn->query($sql);

        if ($result === false) {
            die("ERROR: Could not execute the query: " . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOfficersByCourse($courseId)
    {
        $sql = "SELECT 
                    officers.OFFICER_ID, 
                    officers.USERNAME, 
                    officers.PASSWORD, 
                    students.STUDENT_ID,
                    students.LAST_NAME,
                    students.FIRST_NAME,
                    students.COURSE,
                    students.BLOCK,
                    students.GUARDIAN_PHONE_NO,
                    students.AVATAR,
                    students.STUDENT_NUMBER,
                    students.YEAR,
                    course.COURSE_NAME,
                    course.COURSE_IMAGE,
                    course.DESCRIPTION,
                    course.COLOR
                FROM officers
                JOIN students ON officers.STUDENT_ID = students.STUDENT_ID
                JOIN course ON course.ID = students.COURSE
                WHERE students.COURSE = ?";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $courseId); // Assuming COURSE is an integer ID
        $stmt->execute();
        $result = $stmt->get_result();

        $officers = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        return $officers;
    }



    public function getOfficerById($officerId)
    {
        $sql = "SELECT * FROM officers
           JOIN students on students.STUDENT_ID = officers.STUDENT_ID
         WHERE OFFICER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $officerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $officer = $result->fetch_assoc();

        $stmt->close();
        return $officer;
    }

    public function updateOfficer($officerId, $studentId, $username, $password)
    {
        $sql = "UPDATE officers SET STUDENT_ID = ?, USERNAME = ?, PASSWORD = ? WHERE OFFICER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("issi", $studentId, $username, $password, $officerId);
        $success = $stmt->execute();

        $stmt->close();
        return $success;
    }

    public function deleteOfficer($officerId)
    {
        $sql = "DELETE FROM officers WHERE OFFICER_ID = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $officerId);
        $success = $stmt->execute();

        $stmt->close();
        return $success;
    }

    public function getOfficerByUsernameOrEmail($usernameOrEmail)
    {
        $sql = "SELECT * FROM officers 
        JOIN students on students.STUDENT_ID = officers.STUDENT_ID
        WHERE USERNAME = ? ";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("s", $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $officer = $result->fetch_assoc();

        $stmt->close();
        return $officer;
    }
}
