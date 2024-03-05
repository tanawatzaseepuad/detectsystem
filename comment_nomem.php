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
    <link rel="stylesheet" href="index7.css">
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
            <button type="button" class="logout-link" onclick="window.location.href='login.php';">Logout</button>
        </div>
    </div>
    <center>
        <br></br>
        
        <br><br>
        <form action="postnomem_comment.php" method="post">
            <table>
            <tr>
    <td>Status:</td>
    <td>
        <input type="hidden" name="name" value="User">
        User
    </td>
</tr>
             
                <tr>
                    <td>Request-Status:</td>
                    <td><textarea name="comment" cols="30" row="10" placeholder="Youremail-ขอสิทธ์Officer"></textarea></td>
                </tr>

                <tr>
                    <td><input type='submit' name='submit' value='Post' style="width: 235px; height:40px;"></td>
                </tr>
            </table>
        </form>
    </center>
   
</body>
</html>