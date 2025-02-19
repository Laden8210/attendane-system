<?php

class CourseRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    public function createCourse($courseName, $courseImage, $description, $course_color) {
        $stmt = $this->conn->prepare("INSERT INTO course (COURSE_NAME, COURSE_IMAGE, DESCRIPTION, COLOR) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $courseName,  $courseImage, $description, $course_color);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function getAllCourses() {
        $stmt = $this->conn->prepare("SELECT * FROM course");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getCourseById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM course WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateCourse($id, $courseName, $courseImage, $description, $course_color) {
        $stmt = $this->conn->prepare("UPDATE course SET COURSE_NAME = ?, COURSE_IMAGE = ?, DESCRIPTION = ?, COLOR = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $courseName, $courseImage, $description, $course_color,  $id);
        return $stmt->execute();
    }

    public function deleteCourse($id) {
        $stmt = $this->conn->prepare("DELETE FROM course WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
