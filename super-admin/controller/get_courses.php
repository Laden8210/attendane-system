<?php 

require_once '../../repository/CourseRepository.php';
require_once '../../repository/config.php';

$courseRepo = new CourseRepository($conn);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $courses = $courseRepo->getAllCourses();
    echo json_encode($courses);
 
}
