<?php
require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    $courseRepo = new CourseRepository($conn);

    if ($courseRepo->deleteCourse($course_id)) {
        echo json_encode(['success' => true, 'message' => 'Course deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete course.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Course ID not provided.']);
}
?>
