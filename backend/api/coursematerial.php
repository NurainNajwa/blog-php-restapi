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

// Fetch all course materials
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'coursematerials' && !$id) {
    $sql = "SELECT * FROM course_materials";
    $result = $conn->query($sql);
    $courseMaterials = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $courseMaterials[] = $row;
        }
    }
    echo json_encode($courseMaterials);
}

// Fetch a specific course material
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'coursematerials' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM course_materials WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Course material not found"]);
    }
}

// Insert a new course material
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'coursematerials') {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $fileLink = $conn->real_escape_string($input['fileLink']);
    $sql = "INSERT INTO course_materials (title, description, fileLink) VALUES ('$title', '$description', '$fileLink')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Update a course material
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'coursematerials' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $fileLink = $conn->real_escape_string($input['fileLink']);
    $sql = "UPDATE course_materials SET title='$title', description='$description', fileLink='$fileLink' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating course material: " . $conn->error]);
    }
}

// Partial update (PATCH) a course material
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH' && $resource == 'coursematerials' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $updates = [];
    foreach ($input as $key => $value) {
        $updates[] = "$key = '{$conn->real_escape_string($value)}'";
    }
    $sql = "UPDATE course_materials SET " . implode(', ', $updates) . " WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating course material: " . $conn->error]);
    }
}

// Delete a course material
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'coursematerials' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM course_materials WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting course material: " . $conn->error]);
    }
}

$conn->close();
?>
