<?php
require_once '../../repository/config.php';
require_once '../../repository/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRepository = new UserRepository($conn);


    $course_id = htmlspecialchars($_POST['course']);
    $user_type_id = htmlspecialchars($_POST['user_type']);
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $middle_name = htmlspecialchars(trim($_POST['middle_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));


    if (empty($course_id) || !is_numeric($course_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Select the department.']);
        exit;
    }

    if (empty($user_type_id) || !is_numeric($user_type_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user type ID.']);
        exit;
    }


    if (empty($first_name)) {
        echo json_encode(['status' => 'error', 'message' => 'First name is required.']);
        exit;
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $first_name)) {
        echo json_encode(['status' => 'error', 'message' => 'First name contains invalid characters.']);
        exit;
    }

    if (empty($last_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Last name is required.']);
        exit;
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $last_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Last name contains invalid characters.']);
        exit;
    }

    if (!empty($middle_name) && !preg_match("/^[a-zA-Z\s'-]+$/", $middle_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Middle name contains invalid characters.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters long.']);
        exit;
    }


    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['avatar']['tmp_name']);
        $file_size = $_FILES['avatar']['size'];

        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid avatar file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }


    }


    $file_name = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../resource/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = uniqid() . '-' . basename($_FILES['avatar']['name']);
        $avatar_file_path = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_file_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload avatar.']);
            exit;
        }
    }


    $success = $userRepository->createUser($course_id, $user_type_id, $first_name, $last_name, $middle_name, $email, $password, $file_name);

    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Student added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add student.']);
    }
}
?>
