<?php
if (!isset($_GET['type'])) {
    echo json_encode(['error' => 'Type parameter is missing in the request']);
    exit;
}

$type = $_GET['type'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($type == 'today') {
    $query = "SELECT 
                DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00') as hour_range,
                COUNT(*) as total_quantity
              FROM video_statuses
              WHERE DATE(timestamp) = CURDATE() AND status = 'agree'
              GROUP BY HOUR(timestamp)";
} elseif ($type == 'monthly') {
    $year = $_GET['year'];
    $query = "SELECT DATE_FORMAT(timestamp, '%Y-%m') as month, COUNT(*) as total
              FROM video_statuses
              WHERE YEAR(timestamp) = $year AND status = 'agree'
              GROUP BY MONTH(timestamp)";
} elseif ($type == 'yearly') {
    $query = "SELECT YEAR(timestamp) as year, COUNT(*) as total
              FROM video_statuses
              WHERE status = 'agree'
              GROUP BY YEAR(timestamp)";
} elseif ($type == 'weekly') {
    $query = "SELECT 
                CONCAT(YEAR(timestamp), '-', MONTH(timestamp), '-Week', 
                FLOOR((DAY(timestamp) - 1) / 7) + 1) as week_range, 
                COUNT(*) as total
              FROM video_statuses
              WHERE YEAR(timestamp) = YEAR(CURDATE()) AND MONTH(timestamp) = MONTH(CURDATE()) AND status = 'agree'
              GROUP BY YEAR(timestamp), MONTH(timestamp), FLOOR((DAY(timestamp) - 1) / 7)";
} elseif ($type == 'month') {
    $query = "SELECT 
                DATE_FORMAT(timestamp, '%Y-%m-%d') as date, 
                COUNT(*) as total
              FROM video_statuses
              WHERE YEAR(timestamp) = YEAR(CURDATE()) AND MONTH(timestamp) = MONTH(CURDATE()) AND status = 'agree'
              GROUP BY DATE_FORMAT(timestamp, '%Y-%m-%d')";
} else {
    // Invalid type or missing year for monthly request
    echo json_encode(['error' => 'Invalid request type or missing year for monthly request']);
    exit;
}

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => mysqli_error($conn)]);
    exit;
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
?>