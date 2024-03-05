<?php include('sever.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index10.css">
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
    <div class="table-container">
    <table width="50%" border="1" height="50%">
        <tr>
            <td >
        
            <br>
                <font size="3" color="#ffffff"><b id="room_name_1">ห้อง 16304 ข้างหน้า</b></font>
               
                
                
                <iframe src="http://192.168.1.3:49347/videostream.cgi?user=admin&pwd=888888" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
    <table width="50%" border="1" height="50%">
        <tr>
            <td align="center">
        
          
       
            <br>
                <font size="3" color="#ffffff"><b id="room_name_2">ห้อง 16304 ข้างหน้า</b></font>
              
                
                
                <iframe src="http://192.168.1.4:39190/videostream.cgi?user=admin&pwd=888888" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
    
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>