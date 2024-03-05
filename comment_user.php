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
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="bar-logo">
            <a href="user_page.php">
                <div class="logo-image" style="background-image: url('litter7.png');"></div>
            </a>
        </div>
        <ul class="bar-all">
            <li><a href="cctv_user.php">CCTV</a></li>
            <li><a href="detection_user.php">Detection</a></li>
            <li><a href="gallery_user.php">Gallery</a></li>
            <li><a href="statistics_user.php">Statistics</a></li>
            <li><a href="comment_user.php">Report</a></li>
        </ul>
        <li>Officer</li>
        <div class="bar-btn">
            <button type="button" class="logout-link" onclick="window.location.href='login.php';">Logout</button>
        </div>
    </div>
    <center>
        <br></br>
        
        <br><br>
        <form action="postuser_comment.php" method="post">
            <table>
               <tr>
    <td>Status:</td>
    <td>
        <input type="hidden" name="name" value="officer">
        officer
    </td>
</tr>
                <tr>
                    <td>Camera:</td>
                    <td>
                        <select name="camera">
                        <option value=''>ไม่มี</option>
                            <option value='กล้อง1'>กล้อง1</option>
                            <option value='กล้อง2'>กล้อง2</option>
                        </select>
                    </td>
                    
                   
                </tr>
                <tr>
                    <td>Comment-Report:</td>
                    <td><textarea name="comment" cols="30" row="10" placeholder="Please enter your comment"></textarea></td>
                </tr>
               
                <tr>
                    <td><input type='submit' name='submit' value='Post' style="width: 235px; height:40px;"></td>
                </tr>
            </table>
        </form>
    </center>
   
</body>
</html>