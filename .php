
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script>
    function submitTextForm(form, videoPath) {
    var formData = new FormData(form);

    // Append videoPath to formData
    formData.append('videoPath', videoPath);

    // Use AJAX to send form data to the server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_text.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Handle the response from the server if needed
            console.log(xhr.responseText);
        }
    };

    xhr.send(formData);

    // Prevent the default form submission
    return false;
}
</script>
</head>


<body>
    <div class="navbar">
        <div class="bar-logo">
            <h1>Logo</h1>
        </div>
        <ul class="bar-all">
            <li><a href="user_page.php">Home</a></li>
            <li><a href="gallery_user.php">Gallery</a></li>
            <li><a href="detection.php">Detection</a></li>
            <li><a href="statistics.php">Statistics</a></li>
        </ul>
        <li>User</li>
        <div class="bar-btn">
        
        <button type="button" class="logout-link" onclick="window.location.href='logout.php';">Logout</button>
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
<div class="video-container">
<?php
$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

// ตรวจสอบว่ามีวันที่ถูกส่งมาหรือไม่
if(isset($_POST['search_date'])) {
    $selectedDate = $_POST['search_date'];
    
    // แสดงวีดีโอที่ตรงกับวันที่ที่เลือก
    foreach (scandir($uploadDirectory) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
            $videoPath = '/uploads/' . $file;
            $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));

            // ตรวจสอบว่าเวลาที่แก้ไขล่าสุดตรงกับวันที่ที่เลือกหรือไม่
            if ($lastModifiedTime == $selectedDate) {
?>
<div class="video-frame">
                <video width="520" height="340" controls>
                    <source src="<?php echo $videoPath; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p>: <?php echo $lastModifiedTime; ?></p>
                <form onsubmit="return submitTextForm(this, '<?php echo $videoPath; ?>');" id="textForm_<?php echo $file; ?>">
    <input type="text" name="userText" placeholder="Enter your text">
    <button type="submit" class="alert-button">Show Text</button>
    <input type="hidden" name="videoPath" value="<?php echo $videoPath; ?>">
</form>
                </div>
<?php
            }
        }
    }
} else {
    // แสดงวีดีโอทั้งหมด    
    foreach (scandir($uploadDirectory) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
            $videoPath = '/uploads/' . $file;
            $lastModifiedTime = date("Y-m-d", filemtime($uploadDirectory . $file));
?>
    <div class="video-frame netflix-button4">
            <video width="520" height="340" controls>
                <source src="<?php echo $videoPath; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p>: <?php echo $lastModifiedTime; ?></p>
            <form onsubmit="return submitTextForm(this, '<?php echo $videoPath; ?>');" id="textForm_<?php echo $file; ?>">
    <input type="text" name="userText" placeholder="Enter your text">
    <button type="submit" class="alert-button">Show Text</button>
    <input type="hidden" name="videoPath" value="<?php echo $videoPath; ?>">
</form>
            </div>
<?php
        }
    }
}
?>
</div>
</div>
        </div>
     
        <!-- แบบฟอร์มอัปโหลดวีดีโอ -->
        
    
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>