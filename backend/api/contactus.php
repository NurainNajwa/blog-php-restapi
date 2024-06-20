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

// Fetch all messages
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'messages' && !$id) {
    $sql = "SELECT * FROM messages";
    $result = $conn->query($sql);
    $messages = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
    echo json_encode($messages);
}

// Fetch a specific message
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'messages' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM messages WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Message not found"]);
    }
}

// Insert a new message
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'messages') {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $subject = $conn->real_escape_string($input['subject']);
    $message = $conn->real_escape_string($input['message']);
    $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Message submitted successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Update a message
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'messages' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $subject = $conn->real_escape_string($input['subject']);
    $message = $conn->real_escape_string($input['message']);
    $sql = "UPDATE messages SET name='$name', email='$email', subject='$subject', message='$message' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Message updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating message: " . $conn->error]);
    }
}

// Partial update (PATCH) a message
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH' && $resource == 'messages' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $updates = [];
    foreach ($input as $key => $value) {
        $updates[] = "$key = '{$conn->real_escape_string($value)}'";
    }
    $sql = "UPDATE messages SET " . implode(', ', $updates) . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Message updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating message: " . $conn->error]);
    }
}

// Delete a message
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'messages' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM messages WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Message deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting message: " . $conn->error]);
    }
}

$conn->close();
?>
