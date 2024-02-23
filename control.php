<?php
// Include your database connection code or configuration here
include 'database.php';

// Create an instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// Set headers to allow cross-origin requests (adjust as needed for security)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Check the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Read control_no details
        if (isset($_GET['id'])) {
            // Get control_no details by ID
            $id = $_GET['id'];
            $query = "SELECT * FROM `control_no` WHERE `id` = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $control_no = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($control_no);
        } else {
            // Get all control_no
            $query = "SELECT * FROM `control_no`";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $control_nos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($control_nos);
        }
        break;

    case 'POST':
        // Create a new control_no
        $data = json_decode(file_get_contents("php://input"), true);
        $control_no = $data['control_no'];
        $used = $data['used'];
    
        $query = "INSERT INTO `control_no` (`control_no`, `used`) VALUES (:control_no, :used)";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':control_no', $control_no);
        $stmt->bindParam(':used', $used);
    
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $conn->lastInsertId();
            echo json_encode(['message' => 'Control number created successfully', 'id' => $lastInsertId]);
        } else {
            echo json_encode(['message' => 'Control number creation failed']);
        }
        break;

    case 'PUT':
        // Get the control_no ID from the URL query parameters
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        if ($id === null) {
            echo json_encode(['message' => 'Control number ID not provided']);
            break;
        }
    
        // Get request body data
        $putData = json_decode(file_get_contents("php://input"), true);
    
        // Update specific columns as needed
        $updateQuery = "UPDATE `control_no` SET `control_no` = :control_no, `used` = :used WHERE `id` = :id";
        $stmt = $conn->prepare($updateQuery);
    
        // Bind parameters
        $stmt->bindParam(':control_no', $putData['control_no']);
        $stmt->bindParam(':used', $putData['used']);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Control number updated successfully']);
        } else {
            echo json_encode(['message' => 'Control number update failed']);
        }
        break;

    case 'DELETE':
        // Delete control_no by ID
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        if ($id === null) {
            echo json_encode(['message' => 'Control number ID not provided']);
            break;
        }
    
        $deleteQuery = "DELETE FROM `control_no` WHERE `id` = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Control number deleted successfully']);
        } else {
            echo json_encode(['message' => 'Control number deletion failed']);
        }
        break;
}
?>
