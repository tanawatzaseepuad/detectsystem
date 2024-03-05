<?php
    // เชื่อมต่อกับฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "register";

    // สร้างการเชื่อมต่อ
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // เช็คการเชื่อมต่อ
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // รับค่าที่ส่งมาจากฟอร์ม
    $email = $_POST['email'];
    $userlevel = $_POST['userlevel'];

    // คำสั่ง SQL เพื่ออัปเดตคอลัมน์ userlevel
    $sql = "UPDATE userdata SET userlevel='$userlevel' WHERE email='$email'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Userlevel updated successfully');</script>";
        echo "<script>window.location.href = 'status_admin.php';</script>";
    } else {
        echo "Error updating userlevel: " . mysqli_error($conn);
    }
    
    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
?>