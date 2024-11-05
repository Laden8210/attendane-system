<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';
require_once '../../repository/CourseRepository.php';

$userRepository = new UserRepository($conn);
$courseRepository = new CourseRepository($conn);

// Get total admin count
$totalAdmins = count($userRepository->readAll());

// Get total course count
$totalCourses = count($courseRepository->getAllCourses());

// Return the counts as a JSON response
echo json_encode([
    'totalAdmins' => $totalAdmins,
    'totalCourses' => $totalCourses
]);
?>
