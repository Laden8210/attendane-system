<?php

class CourseRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    public function createCourse($courseName, $courseCode, $courseImage, $description) {
        $stmt = $this->conn->prepare("INSERT INTO COURSE (COURSE_NAME, COURSE_CODE, COURSE_IMAGE, DESCRIPTION) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $courseName, $courseCode, $courseImage, $description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function getAllCourses() {
        $stmt = $this->conn->prepare("SELECT * FROM COURSE");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getCourseById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM COURSE WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateCourse($id, $courseName, $courseCode, $courseImage, $description) {
        $stmt = $this->conn->prepare("UPDATE COURSE SET COURSE_NAME = ?, COURSE_CODE = ?, COURSE_IMAGE = ?, DESCRIPTION = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $courseName, $courseCode, $courseImage, $description, $id);
        return $stmt->execute();
    }

    public function deleteCourse($id) {
        $stmt = $this->conn->prepare("DELETE FROM COURSE WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
