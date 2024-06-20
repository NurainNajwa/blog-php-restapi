<?php
require_once './config.php';
header("Content-Type: application/json");


$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getCourseMaterials':
        getCourseMaterials();
        break;
    case 'getCourseMaterialById':
        getCourseMaterialById();
        break;
    case 'createCourseMaterial':
        createCourseMaterial();
        break;
    case 'updateCourseMaterial':
        updateCourseMaterial();
        break;
    case 'deleteCourseMaterial':
        deleteCourseMaterial();
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

function getCourseMaterials() {
    try {
        $db = new db();
        $conn = $db->connect();
        $sql = "SELECT * FROM coursematerial";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error fetching course materials: " . $e->getMessage()]);
    }
}

function getCourseMaterialById() {
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "SELECT * FROM coursematerial WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $courseMaterial = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($courseMaterial) {
            echo json_encode($courseMaterial);
        } else {
            echo json_encode(["error" => "Course material not found"]);
        }
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

function createCourseMaterial() {
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['title'], $data['description'], $data['link'])) {
            throw new Exception("Required fields missing");
        }
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $description = filter_var($data['description'], FILTER_SANITIZE_STRING);
        $link = filter_var($data['link'], FILTER_SANITIZE_URL);

        $sql = "INSERT INTO coursematerial (title, description, link) VALUES (:title, :description, :link)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        echo json_encode(["message" => "Course material created successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error creating course material: " . $e->getMessage()]);
    }
}

function updateCourseMaterial() {
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['id'], $data['title'], $data['description'], $data['link'])) {
            throw new Exception("Required fields missing");
        }
        $id = $data['id'];
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $description = filter_var($data['description'], FILTER_SANITIZE_STRING);
        $link = filter_var($data['link'], FILTER_SANITIZE_URL);

        $sql = "UPDATE coursematerial SET title = :title, description = :description, link = :link WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        echo json_encode(["message" => "Course material updated successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating course material: " . $e->getMessage()]);
    }
}

function deleteCourseMaterial() {
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "DELETE FROM coursematerial WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo json_encode(["message" => "Course material deleted successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error deleting course material: " . $e->getMessage()]);
    }
}
?>
