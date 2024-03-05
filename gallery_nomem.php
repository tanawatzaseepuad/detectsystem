<?php include('sever.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index6.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>


<body>
    <div class="navbar">
    <div class="bar-logo">
    <a href="nomember.php">
        <div class="logo-image" style="background-image: url('litter7.png');"></div>
    </a>
        </div>
        <ul class="bar-all">
        <li><a href="cctv_nomem.php">CCTV</a></li>
        <li><a href="detection_nomem.php">Detection</a></li>
            <li><a href="gallery_nomem.php">Gallery</a></li>
            
            <li><a href="statistics_nomem.php">Statistics</a></li>
            <li><a href="comment_nomem.php">Request-Status</a></li>
            
        </ul>
        <li>User</li>
        <div class="bar-btn">
        <button type="button" class="logout-link" onclick="window.location.href='logout.php';">Logout</button>
        </div>
    </div>
    <div class="main-box">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon></span>
        <div class="register">
            
            <form action="#">
            <p> ! ไม่สามารถดูรูปภาพ เเละวีดีโอจาก Gallery ได้ เนื่องจากคุณไม่ได้รับสิทธิให้เข้าถึงข้อมูลภายในจากผู้ดูเเลระบบ</p>
            </form>
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>