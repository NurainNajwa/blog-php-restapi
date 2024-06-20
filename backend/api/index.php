<?php
header('Content-Type: application/json');
require_once '../../config.php';

// Helper function to get input data
function get_input_data() {
    return json_decode(file_get_contents('php://input'), true);
}

// Connect to the database
$conn = getDbConnection();

// Parse the request URL to determine the resource and ID
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$path = trim($request_uri[0], '/');
$segments = explode('/', $path);
$resource = $segments[0];
$id = $segments[1] ?? null;

// Fetch all users
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'users' && !$id) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
}

// Fetch a specific user
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'users' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "User not found"]);
    }
}

// Insert a new user
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'users') {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Update a user
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'users' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating user: " . $conn->error]);
    }
}

// Partial update (PATCH) a user
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH' && $resource == 'users' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $updates = [];
    foreach ($input as $key => $value) {
        $updates[] = "$key = '{$conn->real_escape_string($value)}'";
    }
    $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating user: " . $conn->error]);
    }
}

// Delete a user
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'users' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting user: " . $conn->error]);
    }
}

$conn->close();
?>
