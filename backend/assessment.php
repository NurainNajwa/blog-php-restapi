<?php
header("Access-Control-Allow-Origin: http://localhost"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once './config.php'; 

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'createAssessment':
        createAssessment();
        break;
    case 'getAssessments':
        getAssessments();
        break;
    case 'updateAssessment':
        updateAssessment();
        break;
    case 'deleteAssessment':
        deleteAssessment();
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}


function getAssessments() {
    $db = new db(); 
    $pdo = $db->connect();

    try {
        $stmt = $pdo->query('SELECT * FROM assessment'); // Adjust query as per your database structure
        $assessments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($assessments);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error fetching assessments: " . $e->getMessage()]);
    }
}

function createAssessment() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming a JSON payload sent from frontend
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Validate and sanitize input data
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $description = filter_var($data['description'], FILTER_SANITIZE_STRING);
        $dueDate = filter_var($data['dueDate'], FILTER_SANITIZE_STRING);
        $submitLink = filter_var($data['submitLink'], FILTER_SANITIZE_STRING);

        try {
            $stmt = $pdo->prepare('INSERT INTO assessment (title, description, dueDate, submitLink) VALUES (:title, :description, :dueDate, :submitLink)');
            $stmt->execute(['title' => $title, 'description' => $description, 'dueDate' => $dueDate, 'submitLink' => $submitLink]);

            echo json_encode(["message" => "Assessment created successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error creating assessment: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}

function updateAssessment() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['id'];
        
        // Assuming a JSON payload sent from frontend
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Validate and sanitize input data
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $description = filter_var($data['description'], FILTER_SANITIZE_STRING);
        $dueDate = filter_var($data['dueDate'], FILTER_SANITIZE_STRING);
        $submitLink = filter_var($data['submitLink'], FILTER_SANITIZE_STRING);

        try {
            $stmt = $pdo->prepare('UPDATE assessment SET title = :title, description = :description, dueDate = :dueDate, submitLink = :submitLink WHERE id = :id');
            $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description, 'dueDate' => $dueDate, 'submitLink' => $submitLink]);

            echo json_encode(["message" => "Assessment updated successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error updating assessment: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}

function deleteAssessment() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id = $delete_vars['id'];

        try {
            $stmt = $pdo->prepare('DELETE FROM assessment WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            echo json_encode(["message" => "Assessment deleted successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error deleting assessment: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}

?>
