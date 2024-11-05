<?php 


require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){


    $studentRepository = new StudentRepository($conn);

    $last_name = $_POST['last-name'];
    $first_name = $_POST['first-name'];
    $course = $_POST['course'];
    $block = $_POST['block'];
    $guardian_phone_no = $_POST['guardian-phone'];
    $avatar = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar'];
    $imageData = base64_encode(file_get_contents($avatar_tmp['tmp_name']));
    $success = $studentRepository->addStudent($last_name, $first_name, $course, $block, $guardian_phone_no, $imageData);
    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Student added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add student.']);
    }
}

?>