<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the filename and status from the request body
    $data = json_decode(file_get_contents('php://input'), true);
    $filename = $data['filename'];
    $status = $data['status'];
    $lastModifiedTime = $data['lastModifiedTime']; 
 

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "register");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to update status
    $sql = "INSERT INTO video_statuses (filename, status, timestamp) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status), timestamp = VALUES(timestamp)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $filename, $status, $lastModifiedTime); // เพิ่มพารามิเตอร์ lastModifiedTime ในการผูกพารามิเตอร์
    $stmt->execute();
    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send response
    http_response_code(200);
} else {
    // Invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>