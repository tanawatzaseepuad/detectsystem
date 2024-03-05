
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index8.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
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
   
    <div class="main-box">
        <div class="gallery">
            <form action="#" method="post">
                <label for="search_date">Select Date: </label>
                <input type="date" name="search_date" id="search_date">
                <input type="submit" value="Search">
            </form>

            <br></br>

            <table class="image-container" >
            <table >
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/image/';

                    // Check if a date is selected
                    if (isset($_POST['search_date'])) {
                        $selectedDate = $_POST['search_date'];

                        // Display images that match the selected date
                        foreach (scandir($uploadDirectory) as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                                $imagePath = '/image/' . $file;
                                $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));

                                // Check if the last modified time matches the selected date
                                if ($lastModifiedTime == $selectedDate) {
                    ?>
                                    <tr>
                                        <td class="filename"><?php echo pathinfo($file, PATHINFO_FILENAME); ?></td>
                                        <td class="timestamp"><?php echo $lastModifiedTime . " " . date("H:i:s", filemtime($uploadDirectory . $file)); ?></td>
                                        <td class="action">
                                            <button class="view-image" data-image-path="<?php echo $imagePath; ?>">View</button>
                                        </td>
                                    </tr>
                    <?php
                                }
                            }
                        }
                    } else {
                        // Display all images    
                        foreach (scandir($uploadDirectory) as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                                $imagePath = '/image/' . $file;
                                $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));
                    ?>
                                <tr>
                                    <td class="filename"><?php echo pathinfo($file, PATHINFO_FILENAME); ?></td>
                                    <td class="timestamp"><?php echo $lastModifiedTime . " " . date("H:i:s", filemtime($uploadDirectory . $file)); ?></td>
                                    <td class="action">
                                        <button class="view-image" data-image-path="<?php echo $imagePath; ?>">View</button>
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
            // Add click event listeners to the "View" buttons
            var viewButtons = document.querySelectorAll('.view-image');
            viewButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var imagePath = button.getAttribute('data-image-path');
                    createImagePopup(imagePath);
                });
            });
        });

        function createImagePopup(imagePath) {
    // Open a new window or tab with the image
    var imagePopup = window.open('', '_blank', 'width=800,height=600');

    // Set the content of the popup to the image
    imagePopup.document.write(`
        <img src="${imagePath}" alt="Image">
    `);
}
        
    </script>

        <!-- แบบฟอร์มอัปโหลดวีดีโอ -->
    
    
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>