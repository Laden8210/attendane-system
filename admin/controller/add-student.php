<?php 


require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';
require_once '../../repository/UserRepository.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $userRepo = new UserRepository($conn);

    $user = $userRepo->readUser($_SESSION['user_id']);    


    $studentRepository = new StudentRepository($conn);
    $course = $user['course_id'];

 

    if(empty($course) ){
        echo json_encode(['status' => 'error', 'message' => 'Please select set a course for this admin.']);
        exit;
    }


    

    $last_name = $_POST['last-name'];
    $first_name = $_POST['first-name'];
 
    $block = $_POST['block'];
    $guardian_phone_no = $_POST['guardian-phone'];
    $avatar = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar'];
    $year = $_POST['year'];
    $imageData = base64_encode(file_get_contents($avatar_tmp['tmp_name']));
    $success = $studentRepository->addStudent($last_name, $first_name, $course, $block, $guardian_phone_no, $imageData, $year);
    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Student added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add student.']);
    }
}

?>