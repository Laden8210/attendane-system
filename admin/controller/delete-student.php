<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");

require_once '../../repository/config.php';
require_once '../../repository/StudentRepository.php';


include_once 'config/database.php';

parse_str(file_get_contents("php://input"), $requestData);
$studentId = isset($requestData['id']) ? intval($requestData['id']) : null;

if ($studentId) {
    // Create a new StudentRepository object

    $studentRepository = new StudentRepository($conn);  

    // Call the deleteStudent method

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
    // Error if student ID is missing
    echo json_encode([
        "status" => "error",
        "message" => "Invalid student ID."
    ]);
}
?>
