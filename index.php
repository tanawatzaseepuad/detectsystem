<?php include('sever.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index1.css">

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
                <h1>A Feasibly Litterbugging Detection System</h1>
                <p> ระบบตรวจับความเป็นไปได้ในการทิ้งขยะ จะตรวจจับพฤติกรรมการทิ้งขยะของบุคคลทั่วไปที่ใช้พื้นที่สาธารณะ
                    ว่ามีความรับผิดชอบต่อตนเองและผู้อื่นในการใช้พื้นที่สาธารณะมากแค่ไหน
                    การทดลองนี้เป็นการประเมิณพฤติกรรมการทิ้งขยะว่ามีแนวโน้มไปทางแบบไหน
                    และนำไปวัดผลและแสดงผ่านทางกราฟว่ามีการทิ้งขยะเพิ่มขึ้นหรือลดลง</p>
            </div>
        </div>
    </div>

    <div class="team">
    
    </div>
    

    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>


</html>