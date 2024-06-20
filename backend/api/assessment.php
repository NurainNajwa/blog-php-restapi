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

// Fetch all assessments
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'assessments' && !$id) {
    $sql = "SELECT * FROM assessments";
    $result = $conn->query($sql);
    $assessments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $assessments[] = $row;
        }
    }
    echo json_encode($assessments);
}

// Fetch a specific assessment
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'assessments' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM assessments WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Assessment not found"]);
    }
}

// Insert a new assessment
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'assessments') {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $dueDate = $conn->real_escape_string($input['dueDate']);
    $submitLink = $conn->real_escape_string($input['submitLink']);
    $sql = "INSERT INTO assessments (title, description, dueDate, submitLink) VALUES ('$title', '$description', '$dueDate', '$submitLink')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Update an assessment
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'assessments' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $dueDate = $conn->real_escape_string($input['dueDate']);
    $submitLink = $conn->real_escape_string($input['submitLink']);
    $sql = "UPDATE assessments SET title='$title', description='$description', dueDate='$dueDate', submitLink='$submitLink' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating assessment: " . $conn->error]);
    }
}

// Partial update (PATCH) an assessment
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH' && $resource == 'assessments' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $updates = [];
    foreach ($input as $key => $value) {
        $updates[] = "$key = '{$conn->real_escape_string($value)}'";
    }
    $sql = "UPDATE assessments SET " . implode(', ', $updates) . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating assessment: " . $conn->error]);
    }
}

// Delete an assessment
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'assessments' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM assessments WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting assessment: " . $conn->error]);
    }
}

$conn->close();
?>
