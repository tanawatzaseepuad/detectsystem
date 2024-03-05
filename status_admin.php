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

    // คำสั่ง SQL เพื่อดึงรายชื่ออีเมลทั้งหมดจากตาราง userdata
    $sql = "SELECT * FROM userdata";
    $result = mysqli_query($conn, $sql);

    // เริ่มตาราง HTML
   

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index9.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="navbar">
        <div class="bar-logo">
            <a href="admin_page.php">
                <div class="logo-image" style="background-image: url('litter7.png');"></div>
            </a>
        </div>
        <ul class="bar-all">
            <li><a href="cctv_admin.php">CCTV</a></li>
            <li><a href="detection.php">Detection</a></li>
            <li><a href="gallery_admin.php">Gallery</a></li>
            <li><a href="statistics_admin.php">Statistics</a></li>
            <li><a href="status_admin.php">Status</a></li>
            <li><a href="comment_admin.php">Report</a></li>
        </ul>
        <li>Admin</li>
        <div class="bar-btn">
        <button type="button" class="logout-link" onclick="window.location.href='login.php';">Logout</button>
        </div>
    </div>
    <div class="main">
        <div class="main-color">
        <h1>List Member</h1>
            
            <?php   echo "<table border='1'>";
    echo "<tr><th>Email</th><th>Firstname</th><th>Lastname</th><th>Userlevel</th><th>Add Status</th></tr>";
    

    // วนลูปแสดงข้อมูล
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["email"] . "</td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["userlevel"] . "</td><td><form method='post' action='update_userlevel.php'><input type='hidden' name='email' value='" . $row["email"] . "'><select name='userlevel'>
        <option value='admin'>Admin</option><option value=''>User</option><option value='officer'>Officer</option>
        
    </select><button type='submit'>Update</button></form></td></tr>";
    }

    // จบตาราง HTML
    echo "</table>";?>

        </div>
    </div>
  
</body>
</html>