<?php

class UserRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function createUser($course_id, $user_type_id, $first_name, $last_name, $middle_name, $email, $password, $avatar_file_path)
    {
        $sql = "INSERT INTO users (course_id, user_type_id, first_name, last_name, middle_name, email, password, avatar_file_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
    
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("iissssss", $course_id, $user_type_id, $first_name, $last_name, $middle_name, $email, $password, $avatar_file_path);
    
  
        $success = $stmt->execute();
    
        $stmt->close();
    
        return $success;
    }


    public function readUser($user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }


        $stmt->bind_param("i", $user_id);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $user = $result->fetch_assoc();

        $stmt->close();
        return $user;
    }


    public function updateUser($user_id, $course_id, $user_type_id, $first_name, $last_name, $middle_name, $email)
    {
        $sql = "UPDATE users SET course_id = ?, user_type_id = ?, first_name = ?, last_name = ?, middle_name = ?, email = ?
                WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("iissssi", $course_id, $user_type_id, $first_name, $last_name, $middle_name, $email, $user_id);

   
        $success = $stmt->execute();
        
        $stmt->close();
        return $success;
    }

  
    public function deleteUser($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);

        $success = $stmt->execute();

        $stmt->close();
        return $success;
    }

 
    public function readAll()
    {
        $sql = "SELECT * FROM users 
                JOIN course ON users.course_id = course.ID";

        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }


    public function searchUsers($searchTerm)
    {
        $searchTerm = $this->conn->real_escape_string($searchTerm);
        $searchWildcard = "%$searchTerm%";
        
        $sql = "SELECT * FROM users 
                JOIN course ON users.course_id = course.ID 
                WHERE first_name LIKE ? 
                OR last_name LIKE ? 
                OR email LIKE ?";
        
  
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("ERROR: Could not prepare the statement: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $searchWildcard, $searchWildcard, $searchWildcard);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $users = $result->fetch_all(MYSQLI_ASSOC);
        
        $stmt->close();
        return $users;
    }

    public function getUserByUsernameOrEmail($username)
{
    $sql = "SELECT * FROM users WHERE email = ? ";
    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die("ERROR: Could not prepare the statement: " . $this->conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    return $user;
}

}
