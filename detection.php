<?php include('sever.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="detection.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
</head>


<body>
    <div class="navbar">
    <div class="bar-logo">
        <a href="index.php">
        <div class="logo-image" style="background-image: url('litter7.png');"></div>
    </a>
        </div>
        <ul class="bar-all">
        <li><a href="cctv.php">CCTV</a></li>
        <li><a href="detection.php">Detection</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            
            <li><a href="statistics.php">Statistics</a></li>
            
        </ul>
        <div class="bar-btn">
        <button type="button" class="login-link" onclick="window.location.href='login.php';">Login</button>
        </div>
    </div>
    <div class="main">
        <div class="main-color">
            <div class="main-text">
                <h1>Detection</h1>
                <p> สามารถดูโปรเเกรมตรวจจับพฤติกรรมการทิ้งขยะของมนุษย์ได้ ซึงเป็นโปรเเกรมที่ใช้ Background subtraction ร่วมกับการตีกรอบวัตถุ  <br><br><a href="register.php">Register</a>    เพื่อเป็นส่วนหนึ่งกับเรา</p>
            </div>
        </div>
    </div>
    
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>