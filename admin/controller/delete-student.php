<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';

// Get raw data from request
$input = file_get_contents("php://input");
$data = json_decode($input, true);
$studentId = isset($data['id']) ? intval($data['id']) : null;

if ($studentId) {
    $studentRepository = new StudentRepository($conn);
    $result = $studentRepository->delete($studentId);

    if ($result) {
        echo json_encode([
            "status" => "success",
            "message" => "Student deleted successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to delete student."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid student ID."
    ]);
}
?>
