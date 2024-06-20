<?php
header("Access-Control-Allow-Origin: http://localhost"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once './config.php'; 

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'submitForm':
        submitForm();
        break;
    case 'getMessages':
        getMessages();
        break;
    case 'getMessageById':
        getMessageById();
        break;
    case 'deleteMessage':
        deleteMessage();
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
        break;
}

function submitForm() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming a JSON payload sent from frontend
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Validate and sanitize input data
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $subject = filter_var($data['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($data['message'], FILTER_SANITIZE_STRING);

        try {
            $stmt = $pdo->prepare('INSERT INTO message (name, email, subject, message) VALUES (:name, :email, :subject, :message)');
            $stmt->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);

            echo json_encode(["message" => "Message submitted successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error submitting message: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}

function getMessages() {
    $db = new db(); 
    $pdo = $db->connect();

    try {
        $stmt = $pdo->query('SELECT * FROM message');
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($messages);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error fetching messages: " . $e->getMessage()]);
    }
}

function getMessageById() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'];

        try {
            $stmt = $pdo->prepare('SELECT * FROM message WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $message = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($message) {
                echo json_encode($message);
            } else {
                echo json_encode(["error" => "Message not found"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error fetching message: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}

function deleteMessage() {
    $db = new db(); 
    $pdo = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id = $delete_vars['id'];

        try {
            $stmt = $pdo->prepare('DELETE FROM message WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            echo json_encode(["message" => "Message deleted successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error deleting message: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
}
?>
