<?php
require_once 'repository/config.php';
require_once 'repository/UserRepository.php';
require_once 'repository/OfficerRepository.php';

$userRepository = new UserRepository($conn);
$officerRepository = new OfficerRepository($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $course_id = $_POST['course_id'];

    // Check if user exists
    $user = $userRepository->getUserByUsernameOrEmail($username);

    if ($user && $password == $user['password']) {
        // User login successful

        if ($user['user_type_id'] !== 0) {

            if ($user['course_id'] != $course_id) {
                echo json_encode(['success' => false, 'message' => 'Please select your course!']);
                exit;
            }
        }

        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type_id'] = $user['user_type_id'];



        echo json_encode(['success' => true, 'message' => 'Login successful!', 'user_type_id' => $user['user_type_id']]);


        exit;
    } else {

        $officer = $officerRepository->getOfficerByUsernameOrEmail($username);

        if ($officer && $password == $officer['PASSWORD']) {


            if ($officer['COURSE'] != $course_id) {
                echo json_encode(['success' => false, 'message' => 'Please select your course!']);
                exit;
            }

            session_start();
            $_SESSION['officer_id'] = $officer['OFFICER_ID'];

            echo json_encode(['success' => true, 'message' => 'Officer login successful!', 'user_type_id' => 2]);
            exit;
        } else {
            // Login failed
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        }
    }
}
