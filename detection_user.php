<?php
// Assuming you have already established a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Establishing the database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select data from the camera_list table for cameras with IDs 1 and 2
$query = "SELECT id, camera_one, camera_two FROM camera_list WHERE id = 1 OR id = 2";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Fetch data from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Store the camera URLs in variables
        if ($row['id'] == 1) {
            $cameraOneURL = $row['camera_one'];
        } elseif ($row['id'] == 2) {
            $cameraTwoURL = $row['camera_two'];
        }
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle error if the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index10.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://pyscript.net/releases/2024.1.1/core.css" />
<script type="module" src="https://pyscript.net/releases/2024.1.1/core.js"></script>

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
               
                
                
                <iframe src="http://127.0.0.1:8000/stream/video" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
    <table width="50%" border="1" height="50%">
        <tr>
            <td align="center">
        
          
       
            <br>
                <font size="3" color="#ffffff"><b id="room_name_2">ห้อง 16304 ข้างหน้า</b></font>
              
                
                
                <iframe src="http://127.0.0.1:8000/stream/video2" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
  
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>