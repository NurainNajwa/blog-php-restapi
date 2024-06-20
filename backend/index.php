<?php
// In your PHP API endpoint file (index.php)
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once './config.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'getUsers':
        getUsers();
        break;
    case 'getUserById':
        getUserById();
        break;
    case 'createUser':
        createUser();
        break;
    case 'login':
        login();
        break;
    case 'updateUser':
        updateUser();
        break;
    case 'deleteUser':
        deleteUser();
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

function getUsers(){
    try {
        $db = new db();
        $conn = $db->connect();
        $sql = "SELECT * FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null; // Close the connection
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error fetching users: " . $e->getMessage()]);
    }
}


function getUserById(){
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
        $conn = null; // Close the connection
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

function createUser(){
    try {
        $db = new db();
        $conn = $db->connect();
        // Get JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json_data, true);
        // Check if required fields are present
        if (!isset($data['fullName'], $data['username'], $data['email'], $data['password'], $data['matricNumber'], $data['yearOfStudy'])) {
            throw new Exception("Required fields missing");
        }
        $fullName = filter_var($data['fullName'], FILTER_SANITIZE_STRING);
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $matricNumber = filter_var($data['matricNumber'], FILTER_SANITIZE_STRING);
        $yearOfStudy = filter_var($data['yearOfStudy'], FILTER_SANITIZE_NUMBER_INT);

        $sql = "INSERT INTO users (fullName, username, email, password, matricNumber, yearOfStudy) VALUES (:fullName, :username, :email, :password, :matricNumber, :yearOfStudy)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':fullName', $fullName);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':matricNumber', $matricNumber);
        $stmt->bindValue(':yearOfStudy', $yearOfStudy);
        $stmt->execute();
        echo json_encode(["message" => "User created successfully"]);
        $conn = null; // Close the connection
    } catch (Exception $e) {
        echo json_encode(["error" => "Error creating user: " . $e->getMessage()]);
    }
}

function login(){
    try {
        $db = new db();
        $conn = $db->connect();
        // Get JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json_data, true);
        
        if (!isset($data['username'], $data['password'])) {
            throw new Exception("Username and password are required for login.");
        }
        
        // Validate and sanitize inputs
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $password = $data['password'];
        
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Remove password from response
            echo json_encode(["message" => "Login successful", "user" => $user]);
        } else {
            echo json_encode(["error" => "Invalid username or password"]);
        }
        
        $conn = null; // Close the connection
    } catch (Exception $e) {
        // Log detailed error to file or central logging system
        echo json_encode(["error" => "Error logging in: " . $e->getMessage()]);
    }
}

function updateUser(){
    try {
        $db = new db();
        $conn = $db->connect();
        // Get JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json_data, true);
        // Check if required fields are present
        // if (!isset($data['id']) || !isset($data['fullName']) || !isset($data['username']) || !isset($data['email']) || !isset($data['password']) || !isset($data['matricNumber'])|| !isset($data['yearOfStudy'])) {
        //     throw new Exception("ID, name, and email are required for updating user.");
        // }
        if (!isset($data['id'], $data['fullName'], $data['username'], $data['email'], $data['password'], $data['matricNumber'], $data['yearOfStudy'])) {
            throw new Exception("Required fields missing");
        }
        $id = $data['id'];
        $fullName = filter_var($data['fullName'], FILTER_SANITIZE_STRING);
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $matricNumber = filter_var($data['matricNumber'], FILTER_SANITIZE_STRING);
        $yearOfStudy = filter_var($data['yearOfStudy'], FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE users SET fullName = :fullName, username = :username, email = :email, password = :password, matricNumber = :matricNumber, yearOfStudy = :yearOfStudy WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':fullName', $fullName);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':matricNumber', $matricNumber);
        $stmt->bindValue(':yearOfStudy', $yearOfStudy);
        
        $stmt->execute();
        echo json_encode(["message" => "User updated successfully"]);
        $conn = null; // Close the connection
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating user: " . $e->getMessage()]);
    }
}

function patchUser(){
    try {
        $db = new db();
        $conn = $db->connect();
        // Get JSON data from the request body
        $json_data = file_get_contents('php://input');
        // Decode JSON data into associative array
        $data = json_decode($json_data, true);
        // Check if required fields are present
        if (!isset($data['id'])) {
            throw new Exception("ID is required for patching user.");
        }
        $id = $data['id'];
        $fields = [];
        if (isset($data['fullName'])) {
            $fields[] = "fullName = :fullName";
        }
        if (isset($data['username'])) {
            $fields[] = "username = :username";
        }
        if (isset($data['email'])) {
            $fields[] = "email = :email";
        }
        if (isset($data['password'])) {
            $fields[] = "password = :password";
        }
        if (isset($data['matricNumber'])) {
            $fields[] = "matricNumber = :matricNumber";
        }
        if (isset($data['yearOfStudy'])) {
            $fields[] = "yearOfStudy = :yearOfStudy";
        }

        // Build SQL query
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        if (isset($data['fullName'])) {
            $stmt->bindValue(':fullName', $data['fullName']);
        }
        if (isset($data['username'])) {
            $stmt->bindValue(':username', $data['username']);
        }
        if (isset($data['email'])) {
            $stmt->bindValue(':email', $data['email']);
        }
        if (isset($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT); // Hash new password
            $stmt->bindValue(':password', $hashedPassword);
        }
        if (isset($data['matricNumber'])) {
            $stmt->bindValue(':matricNumber', $data['matricNumber']);
        }
        if (isset($data['yearOfStudy'])) {
            $stmt->bindValue(':yearOfStudy', $data['yearOfStudy']);
        }

        $stmt->execute();
        echo json_encode(["message" => "User patched successfully"]);
        $conn = null; // Close the connection
    } catch (Exception $e) {
        echo json_encode(["error" => "Error patching user: " . $e->getMessage()]);
    }
}

function deleteUser(){
    try {
        $db = new db();
        $conn = $db->connect();
        // Get the user ID from the request
        $id = $_GET['id'];
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo json_encode(["message" => "User deleted successfully"]);
        $conn = null; // Close the connection
    } catch (Exception $e) {
        echo json_encode(["error" => "Error deleting user: " . $e->getMessage()]);
    }
}
?>