<?php 
include_once 'Comment.php';
$com = new Comment(); 

if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<span style='color: black; font-size: 20px'>".$msg."</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index11.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
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
            <li><a href="detection_admin.php">Detection</a></li>
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
    <center>
    <br></br>
    
        <br></br>
        <div class="main-box3">
        <li>กล่องรับรายงานจาก Officer & User</li>
        </div>
        <div class="main-box">
        
            <ul style="float: left;">
                <?php
                if($result = $com->index()){
                    while ($data = $result->fetch_assoc()){
                ?>
                <li class="list-item">
                    <b><?php echo $data['name']; ?>-<?php echo $data['camera']; ?></b> - <?php echo $data['comment']; ?>  - <?php echo $com->dateFormat($data['comment_time']); ?>
                </li>
                <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <br><br>
        
    </center>
    
</body>
</html>