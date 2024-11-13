<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'makeup_artist';

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST requests for the contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['action']) && $data['action'] === 'contact') {
        $name = $data['name'];
        $email = $data['email'];
        $message = $data['message'];

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to send message"]);
        }
        $stmt->close();
    }

    if (isset($data['action']) && $data['action'] === 'appointment') {
        $client_name = $data['client_name'];
        $client_email = $data['client_email'];
        $appointment_date = $data['appointment_date'];
        $appointment_type = $data['appointment_type'];

        $stmt = $conn->prepare("INSERT INTO appointments (client_name, client_email, appointment_date, appointment_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $client_name, $client_email, $appointment_date, $appointment_type);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Appointment booked successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to book appointment"]);
        }
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
