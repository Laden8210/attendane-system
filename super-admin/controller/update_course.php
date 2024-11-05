<?php
require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = intval($_POST['course_id']);
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $description = $_POST['description'];
    $file_name = null;

    // Handle file upload if a new image is provided
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../resource/uploads/';
        $file_name = uniqid() . '-' . basename($_FILES['course_image']['name']);
        $target_file = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['course_image']['tmp_name'], $target_file)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload course image.']);
            exit;
        }
    }

    $courseRepo = new CourseRepository($conn);

    if ($file_name) {
        $success = $courseRepo->updateCourse($course_id, $course_name, $course_code, $file_name, $description);
    } else {
        // If no new image, keep the old image in place
        $existingCourse = $courseRepo->getCourseById($course_id);
        $success = $courseRepo->updateCourse($course_id, $course_name, $course_code, $existingCourse['COURSE_IMAGE'], $description);
    }

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Course updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update course.']);
    }
}
?>
