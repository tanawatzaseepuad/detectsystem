<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ของ MySQL
$password = ""; // รหัสผ่านของ MySQL
$dbname = "register"; // ชื่อฐานข้อมูลที่คุณสร้างไว้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เตรียมคำสั่ง SQL สำหรับการ select ข้อมูล
$sql = "SELECT message FROM camera_data";

$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // แสดงข้อมูลทั้งหมด
    while($row = $result->fetch_assoc()) {
        echo "ข้อความ: " . $row["message"] . "<br>";
    }
} else {
    echo "ไม่พบข้อมูล";
}
$conn->close();
?>