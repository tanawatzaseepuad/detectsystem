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
    $camera_one = $_POST['camera_one'];
    $camera_two = $_POST['camera_two'];
    $id = $_POST['id'];

    // คำสั่ง SQL เพื่ออัปเดตคอลัมน์ userlevel
    $sql = "UPDATE camera_list SET camera_one='$camera_one', camera_two='$camera_two' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Camera settings updated successfully');</script>";
        echo "<script>window.location.href = 'cctv_admin.php';</script>";
    } else {
        echo "Error updating camera settings: " . mysqli_error($conn);
    }
    
    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
?>