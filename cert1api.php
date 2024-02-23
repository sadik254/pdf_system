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
        // Read user details
        if (isset($_GET['id'])) {
            // Get user details by ID
            $id = $_GET['id'];
            $query = "SELECT * FROM `user` WHERE `id` = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($user);
        } else {
            // Get all users
            $query = "SELECT * FROM `user`";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        }
        break;

    case 'POST':
        // Create a new user
        $data = json_decode(file_get_contents("php://input"), true);
        // $id = $data['id'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $gender = $data['gender'];
        $dob = $data['dob'];
        $control_no = $data['control_no'];
        $wp_id = $data['wp_id'];
    
        $query = "INSERT INTO `user` ( `firstname`, `lastname`, `email`, `gender`, `dob`, `control_no`, `wp_id`) VALUES ( :firstname, :lastname, :email, :gender, :dob, :control_no, :wp_id)";
    
        $stmt = $conn->prepare($query);
        // $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':control_no', $control_no);
        $stmt->bindParam(':wp_id', $wp_id);
    
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $conn->lastInsertId();
    
            // Redirect to the certificate1.php page with the user's ID
            header('Location: certificate2.php?id=' . $lastInsertId);
            exit; // Terminate further execution
        } else {
            echo json_encode(['message' => 'User creation failed']);
        }
        break;
        

    case 'PUT':
        // Get the user ID from the URL query parameters
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        if ($id === null) {
            echo json_encode(['message' => 'User ID not provided']);
            break;
        }
    
        // Get request body data
        $putData = json_decode(file_get_contents("php://input"), true);
    
        // Update specific columns as needed
        $updateQuery = "UPDATE `user` SET `firstname` = :firstname, `lastname` = :lastname, `email` = :email, `gender` = :gender, `dob` = :dob, `control_no` = :control_no, `wp_id` = :wp_id WHERE `id` = :id";
        $stmt = $conn->prepare($updateQuery);
    
        // Bind parameters
        $stmt->bindParam(':firstname', $putData['firstname']);
        $stmt->bindParam(':lastname', $putData['lastname']);
        $stmt->bindParam(':email', $putData['email']);
        $stmt->bindParam(':gender', $putData['gender']);
        $stmt->bindParam(':dob', $putData['dob']);
        $stmt->bindParam(':control_no', $putData['control_no']);
        $stmt->bindParam(':wp_id', $putData['wp_id']);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            echo json_encode(['message' => 'User updated successfully']);
        } else {
            echo json_encode(['message' => 'User update failed']);
        }
        break;        

    case 'DELETE':
        // Delete user by ID
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        if ($id === null) {
            echo json_encode(['message' => 'User ID not provided']);
            break;
        }
    
        $deleteQuery = "DELETE FROM `user` WHERE `id` = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            echo json_encode(['message' => 'User deletion failed']);
        }
        break;
        
}
?>
