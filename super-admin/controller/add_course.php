<?php 

require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

$courseRepo = new CourseRepository($conn);

try{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $courseName = htmlspecialchars(trim($_POST['course_name']));

        $description = htmlspecialchars(trim($_POST['description']));
    
        $courseImage = $_FILES['course_image'];

        $course_color = htmlspecialchars((trim($_POST['course_color'])));
    
    
        $uniqueFilename = uniqid() . '-' . basename($courseImage['name']);
        $imagePath = '../../resource/uploads/' . $uniqueFilename;
    
        if (move_uploaded_file($courseImage['tmp_name'], $imagePath)) {
            if ($courseRepo->createCourse($courseName, $uniqueFilename, $description, $course_color)) {
                echo json_encode(['success' => true, 'message' => 'Course added successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add course.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
        }
    }
    
}catch(Exception $e){
    echo $e;
}
