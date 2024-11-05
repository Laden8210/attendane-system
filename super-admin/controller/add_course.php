<?php 

require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

$courseRepo = new CourseRepository($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $courseName = htmlspecialchars(trim($_POST['course_name']));
    $courseCode = htmlspecialchars(trim($_POST['course_code']));
    $description = htmlspecialchars(trim($_POST['description']));

    $courseImage = $_FILES['course_image'];

    // Generate a unique filename by appending a timestamp
    $uniqueFilename = uniqid() . '-' . basename($courseImage['name']);
    $imagePath = '../../resource/uploads/' . $uniqueFilename;

    if (move_uploaded_file($courseImage['tmp_name'], $imagePath)) {
        if ($courseRepo->createCourse($courseName, $courseCode, $uniqueFilename, $description)) {
            echo json_encode(['success' => true, 'message' => 'Course added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add course.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
    }
}
