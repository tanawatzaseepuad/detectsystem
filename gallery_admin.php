<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "register");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL statement to retrieve latest status for each filename
$sql = "SELECT vs.filename, vs.status, vs.timestamp, latest.latest_timestamp
        FROM video_statuses AS vs
        INNER JOIN (
            SELECT filename, MAX(timestamp) AS latest_timestamp
            FROM video_statuses
            GROUP BY filename
        ) AS latest 
        ON vs.filename = latest.filename AND vs.timestamp = latest.latest_timestamp";
$result = $conn->query($sql);
$sql3 = "SELECT filename, status FROM video_statuses";

$result2 = $conn->query($sql3);

// Create an associative array to store latest statuses
$latestStatuses = array();
$existingStatuses = array();

if ($result->num_rows > 0) {
    // Fetch each row and store the latest status in the associative array
    while ($row = $result->fetch_assoc()) {
        $latestStatuses[$row['filename']] = array('timestamp' => $row['latest_timestamp'], 'status' => $row['status']);
        
    }

    
}
if ($result2->num_rows > 0) {
    // Fetch each row and store the latest status in the associative array
    while ($row = $result2->fetch_assoc()) {
       
        $existingStatuses[$row['filename']] = $row['status'];
    }}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset=" UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A Feasibly Litterbugging Detection System</title>
        <link rel="stylesheet" href="index8.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <?php
// ตัวอย่างการดึงข้อมูลจากไฟล์ text

?>
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
    <div class="main-box4">
    <form action="#" method="post">
    <label for="delete_option">Select Delete file: </label>
    <select name="delete_option" id="delete_option">
    <option value="1">1 Month</option>
            <option value="2">2 Months</option>
            <option value="3">3 Months</option>
            <option value="4">4 Month</option>
            <option value="5">5 Months</option>
            <option value="6">6 Months</option>
            <option value="7">7 Month</option>
            <option value="8">8 Months</option>
            <option value="9">9 Months</option>
            <option value="10">10 Month</option>
            <option value="11">11 Months</option>
            <option value="12">12 Months</option>
    </select>
    <input type="submit" value="Delete Files">
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_option"])) {
    $deleteOption = $_POST["delete_option"];
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

    // Calculate timestamp threshold based on selected option
    $timestampThreshold = strtotime("-{$deleteOption} months");

    // Iterate through files in the upload directory
    foreach (scandir($uploadDirectory) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'gif') {
            $filePath = $uploadDirectory . $file;
            $fileLastModified = filemtime($filePath);

            // Check if the file's last modified timestamp is before the threshold
            if ($fileLastModified < $timestampThreshold) {
                // Delete the file
                unlink($filePath);
            }
        }
    }

    // Redirect back to the page to avoid resubmission
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit;
}
?>
</div>
</form>
    <div class="main-box">
        <div class="gallery">
        <form action="#" method="post">
    <label for="search_date">Select Date: </label>
    <input type="date" name="search_date" id="search_date">
    <input type="submit" value="Search">
</form>

<br></br>

            <table class="video-container">
            <table>
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                            <th>Status</th>
                        
                            <th>Check</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

                    // Check if a date is selected
                    if (isset($_POST['search_date'])) {
                        $selectedDate = $_POST['search_date'];

                        // Display videos that match the selected date
                        foreach (scandir($uploadDirectory) as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'gif') {
                                $videoPath = '/uploads/' . $file;
                                $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));

                                // Check if the last modified time matches the selected date
                                if ($lastModifiedTime == $selectedDate) {
                    ?>
                    
                                    <tr>
                                        <td class="filename"><?php echo pathinfo($file, PATHINFO_FILENAME); ?></td>
                                        <td class="timestamp"><?php echo $lastModifiedTime . " " . date("H:i:s", filemtime($uploadDirectory . $file)); ?></td>
                                        <td class="action">
                                            <button class="view-video" data-video-path="<?php echo $videoPath; ?>">View</button>
                                        </td>
                                        <td class="check"> <!-- เพิ่มคอลัมน์ Check -->
                                        <?php
                                        // Check if filename exists in latest statuses array
                                        if (array_key_exists(pathinfo($file, PATHINFO_FILENAME), $latestStatuses)) {
                                            // Get the latest status and timestamp for the filename
                                            $latestStatus = $latestStatuses[pathinfo($file, PATHINFO_FILENAME)]['status'];
                                            $latestTimestamp = $latestStatuses[pathinfo($file, PATHINFO_FILENAME)]['timestamp'];
                                            echo "Status: $latestStatus ";
                                        }
                                        ?>
                                    </td>
      
                                        <td class="status">
   
                                        <?php
    // Check if status exists for the current filename
    $status = isset($existingStatuses[pathinfo($file, PATHINFO_FILENAME)]) ? $existingStatuses[pathinfo($file, PATHINFO_FILENAME)] : '';

    // Display buttons based on status
    if ($status === 'agree') {
        echo '<button class="agree-btn" style="display: none;">Agree</button>';
        echo '<button class="disagree-btn" style="display: none;">Disagree</button>';
    } elseif ($status === 'disagree') {
        echo '<button class="agree-btn">Agree</button>';
        echo '<button class="disagree-btn" style="display: none;">Disagree</button>';
    } else {
        echo '<button class="agree-btn">Agree</button>';
        echo '<button class="disagree-btn">Disagree</button>';
    }
    ?>
</td>

                                    </tr>
                    <?php
                                }
                            }
                        }
                    } else {
                        // Display all videos    
                        foreach (scandir($uploadDirectory) as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'gif') {
                                $videoPath = '/uploads/' . $file;
                                $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));
                    ?>
                                <tr>
                                    <td class="filename"><?php echo pathinfo($file, PATHINFO_FILENAME); ?></td>
                                    <td class="timestamp"><?php echo $lastModifiedTime . " " . date("H:i:s", filemtime($uploadDirectory . $file)); ?></td>
                                    <td class="action">
                                        <button class="view-video" data-video-path="<?php echo $videoPath; ?>">View</button>
                                    </td>
                                    <td class="check"> <!-- เพิ่มคอลัมน์ Check -->
                                        <?php
                                        // Check if filename exists in latest statuses array
                                        if (array_key_exists(pathinfo($file, PATHINFO_FILENAME), $latestStatuses)) {
                                            // Get the latest status and timestamp for the filename
                                            $latestStatus = $latestStatuses[pathinfo($file, PATHINFO_FILENAME)]['status'];
                                            $latestTimestamp = $latestStatuses[pathinfo($file, PATHINFO_FILENAME)]['timestamp'];
                                            echo "Status: $latestStatus ";
                                        }
                                        ?>
                                    </td>
                                    <td class="status">


                                    <?php
    // Check if status exists for the current filename
    $status = isset($existingStatuses[pathinfo($file, PATHINFO_FILENAME)]) ? $existingStatuses[pathinfo($file, PATHINFO_FILENAME)] : '';

    // Display buttons based on status
    if ($status === 'agree') {
        echo '<button class="agree-btn" style="display: none;">Agree</button>';
        echo '<button class="disagree-btn" style="display: none;">Disagree</button>';
    } elseif ($status === 'disagree') {
        echo '<button class="agree-btn">Agree</button>';
        echo '<button class="disagree-btn" style="display: none;">Disagree</button>';
    } else {
        echo '<button class="agree-btn">Agree</button>';
        echo '<button class="disagree-btn">Disagree</button>';
    }
    ?>
        </td>
       
                                </tr>
                                
                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>
                
            </table>
</div>
</div>
        </div>
       
        <script>
          document.addEventListener('DOMContentLoaded', function () {
        var viewButtons = document.querySelectorAll('.view-video');
        viewButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var videoPath = button.getAttribute('data-video-path');
                createVideoPopup(videoPath);
            });
        });
        var agreeButtons = document.querySelectorAll('.agree-btn');
    var disagreeButtons = document.querySelectorAll('.disagree-btn');

    function handleButtonClick(button, status) {
    var filename = button.closest('tr').querySelector('.filename').textContent;
    var lastModifiedTime = button.closest('tr').querySelector('.timestamp').textContent; // เพิ่มบรรทัดนี้เพื่อรับค่าเวลาจากตาราง
    setStatus(filename, status, lastModifiedTime); // เพิ่มพารามิเตอร์ lastModifiedTime ในการเรียกใช้ setStatus()

    // Hide both agree and disagree buttons
    agreeButtons.forEach(function (btn) {
        btn.style.display = 'none';
    });

    disagreeButtons.forEach(function (btn) {
        btn.style.display = 'none';
    });

    alert('Data saved successfully.');
}

    agreeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            handleButtonClick(button, 'agree');
        });
    });

    disagreeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            handleButtonClick(button, 'disagree');
        });
    });
});


function setStatus(filename, status, lastModifiedTime) {
    // Send an AJAX request to update the status in the database
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ filename: filename, status: status, lastModifiedTime: lastModifiedTime }), // เพิ่มค่า lastModifiedTime ในการส่งข้อมูล
    })
    .then(response => {
        if (response.ok) {
            console.log('Status updated successfully.');
            // Reload the page after updating status
            location.reload();
        } else {
            console.error('Failed to update status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

        
      
        function createVideoPopup(videoPath, filename, lastModifiedTime) {
            // Show the modal
            document.getElementById('videoModal').style.display = 'block';

            // Set the video source, filename, and timestamp in the modal
            document.getElementById('modalVideo').src = videoPath;
            document.getElementById('modalFilename').textContent = 'File: ' + filename;
            document.getElementById('modalTimestamp').textContent = 'Timestamp: ' + lastModifiedTime;
        }

        function createVideoPopup(videoPath) {
            // Open a new window or tab with the video
            var videoPopup = window.open('', '_blank', 'width=800,height=600');

            // Set the content of the popup to the video player
            videoPopup.document.write(`
        <img src="${videoPath}" alt="GIF">
    `);
        }

    </script>   
        <!-- แบบฟอร์มอัปโหลดวีดีโอ -->
        
    <!-- Add JavaScript to show/hide notifications -->
    
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

    </html>