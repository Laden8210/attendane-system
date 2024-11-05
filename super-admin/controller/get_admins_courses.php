<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';
require_once '../../repository/CourseRepository.php';
$userRepository = new UserRepository($conn);
$courseRepository = new CourseRepository($conn);


$admins = $userRepository->readAll();


$courses = $courseRepository->getAllCourses();


echo json_encode([
    'admins' => $admins,
    'courses' => $courses
]);
?>
