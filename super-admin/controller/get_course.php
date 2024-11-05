<?php
require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    $courseRepo = new CourseRepository($conn);

    $course = $courseRepo->getCourseById($course_id);

    if ($course) {
        echo json_encode($course);
    } else {
        echo json_encode(['error' => 'Course not found.']);
    }
} else {
    echo json_encode(['error' => 'Course ID not provided.']);
}
?>
