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
    <meta charset="UTF-8">
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
    <div class="table-container">
    <table width="50%" border="1" height="50%">
        <tr>
            <td >
            <form action="insert_data.php" method="post">
        <label for="camera_one">Camera name:</label><br>
        <input type="text" id="camera_one" name="camera_one"><br>

        <input type="hidden" name="id" value="1"> <!-- Assuming you have an ID for the camera settings -->
        <input type="submit" value="Update">
    </form>
    <br>
            <?php echo $cameraOneURL; ?>
            <br>
                
               
                
            
                <iframe src="http://192.168.1.3:49347/videostream.cgi?user=admin&pwd=888888" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
    <table width="50%" border="1" height="50%">
        <tr>
            <td align="center">
            <form action="insert_data.php" method="post">
      
        <label for="camera_two">Camera name:</label><br>
        <input type="text" id="camera_two" name="camera_two"><br>
        <input type="hidden" name="id" value="2"> <!-- Assuming you have an ID for the camera settings -->
        <input type="submit" value="Update">
    </form>
    <br>
            <?php echo $cameraTwoURL; ?>
            <br>
           
              
                
           
                <iframe src="http://192.168.1.4:39190/videostream.cgi?user=admin&pwd=888888" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>



</div>
    <div class="table-container">
        
        <table width="50%" border="1" height="50%">
            <tr>
                <td align="center">
                    <form>
                        <label  for="room1_src">Add Camera</label><br>
                        <input type="text" id="room1_src" name="room1_src" placeholder="IP camera src"><br>
                        
                        <button class="netflix-button4" type="button" onclick="changeRoomSrc('room1')">Add view</button>
                    </form>
                    <iframe id="room1_iframe" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
                </td>
            </tr>
        </table>
        <table width="50%" border="1" height="50%">
            
            <tr>
                
                <td align="center">
                    <form>
                        
                        <label for="room2_src">Add Camera</label><br>
                        <input type="text" id="room2_src" name="room2_src" placeholder="IP camera src"><br>
                        
                        <button class="netflix-button4" type="button" onclick="changeRoomSrc('room2')">Add view</button>
                    </form>
                    <iframe id="room2_iframe" align="center" frameborder="0" height="90%" width="100%" marginheight="1" marginwidth="1" scrolling="auto"></iframe>
                </td>
            </tr>
        </table>
    </div>
    <script>
        function changeRoomSrc(room) {
            var srcInput = document.getElementById(room + "_src").value;
           
            document.getElementById(room + "_iframe").src = srcInput;
            document.querySelector("#" + room + "_iframe").setAttribute("title", textInput);
        }
    </script>
</body>

</html>