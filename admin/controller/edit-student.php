<?php

require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';
require_once '../../repository/UserRepository.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userRepo = new UserRepository($conn);

    // Fetch user information
    $user = $userRepo->readUser($_SESSION['user_id']);    

    $studentRepository = new StudentRepository($conn);
    $course = $user['course_id'];

    if (empty($course)) {
        echo json_encode(['status' => 'error', 'message' => 'Please set a course for this admin.']);
        exit;
    }

    // Collect data from POST
    $student_id = $_POST['student-id'];
    $last_name = $_POST['last-name'];
    $first_name = $_POST['first-name'];
    $block = $_POST['block'];
    $guardian_phone_no = $_POST['guardian-phone'];
    $year = $_POST['year'];

    // Handle avatar update if provided
    $avatar = $_FILES['avatar']['name'];
    if (!empty($avatar)) {
        $avatar_tmp = $_FILES['avatar'];
        $imageData = base64_encode(file_get_contents($avatar_tmp['tmp_name']));
    } else {
        // If no new avatar is uploaded, fetch the existing avatar from the database
        $existingStudent = $studentRepository->read($student_id);
        $imageData = $existingStudent['AVATAR'];
    }

    // Update student record
    $success = $studentRepository->update($student_id, $last_name, $first_name, $block, $guardian_phone_no, $imageData, $year);
    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Student updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update student.']);
    }
}

?>
