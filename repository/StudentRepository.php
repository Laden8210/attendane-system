<?php

class StudentRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addStudent($last_name, $first_name, $course, $block, $guardian_phone_no, $avatar, $year)
    {
        try {
            $this->conn->begin_transaction();
            $this->conn->autocommit(false);

            $student_number = $this->generateStudentNumber($course, $block);

            $this->conn->query("INSERT INTO students (LAST_NAME, FIRST_NAME, COURSE, BLOCK, GUARDIAN_PHONE_NO, AVATAR, STUDENT_NUMBER, YEAR) 
            VALUES ('$last_name', '$first_name', '$course', '$block', '$guardian_phone_no', '$avatar', '$student_number', '$year')");
            $student_id = $this->conn->insert_id;
            $this->conn->commit();
            return $student_id;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }


    private function generateStudentNumber($course, $block)
    {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM students WHERE COURSE = '$course' AND BLOCK = '$block'");
        $count = $result->fetch_assoc()['count'];
        $count++;

        $student_number = $course . $block . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);

        return $student_number;
    }

    public function readStudentByID($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function readStudentByOfficerID($id)
    {
        $stmt = $this->conn->prepare("SELECT * 
FROM students 
JOIN officers 
ON students.STUDENT_ID = officers.STUDENT_ID 
WHERE officers.OFFICER_ID = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function readAll()
    {
        $result = $this->conn->query("SELECT * FROM students");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function readByCourse($course)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students 
        join course on students.COURSE = course.ID
        WHERE COURSE = ?");
        $stmt->bind_param("s", $course);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function readByStudentNumber($student_number)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE student_number = ?");
        $stmt->bind_param("s", $student_number);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function read($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $last_name, $first_name, $middle_name, $course, $block, $guardian_phone_no, $avatar)
    {
        $stmt = $this->conn->prepare("UPDATE students SET LAST_NAME = ?, FIRST_NAME = ?, LAST_NAME = ?, COURSE = ?, BLOCK = ?, GUARDIAN_PHONE_NO = ?, AVATAR = ? WHERE student_id = ?");
        $stmt->bind_param("ssssssbi", $last_name, $first_name, $middle_name, $course, $block, $guardian_phone_no, $avatar, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
