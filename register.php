<?php 
session_start();
require_once "sever.php"; // ต้องแก้ไขเส้นทางไฟล์เชื่อมต่อฐานข้อมูลให้ถูกต้อง

if (isset($_POST['submit'])) { // ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่

    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    

    // ตรวจสอบว่ามีชื่อผู้ใช้นี้อยู่แล้วหรือไม่
    $user_check = "SELECT * FROM userdata WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "<script>alert('Username already exists');</script>";
    } else {
        $password_enc = md5($password); // ในที่นี้ใช้ md5 เป็นตัวอย่าง แต่ไม่แนะนำในการใช้งานจริง

        $query = "INSERT INTO userdata (email, password, firstname, lastname)
                  VALUES ('$email', '$password_enc', '$firstname', '$lastname' )";

        $result = mysqli_query($conn, $query);
        

        if ($result) {
            echo "Insert user successfully";
            $_SESSION['success'] = "Insert user successfully";
            echo "<script>alert('Insert user successfully');</script>";
            // รอสักครู่ก่อนจะ redirect ไปหน้า login.php
            echo "<script>window.location.href = 'login.php';</script>";
            
            exit();
        
        } else {
            $_SESSION['error'] = "Something went wrong";
            
            exit();
         
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Feasibly Litterbugging Detection System</title>
    <link rel="stylesheet" href="index3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
        <button type="button" class="logout-link" onclick="window.location.href='login.php';">Login</button>
        </div>
    </div>
    <div class="main-box">
    <div class="header">
    <h2>Register</h2>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
    <div class="input-group">
        <label for="firstname">Firstname</label>
        <input class="netflix-button" type="text" name="firstname">
    </div>
    <div class="input-group">
        <label for="lastname">Lastname</label>
        <input class="netflix-button" type="text" name="lastname">
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input class="netflix-button" type="text" name="email">
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input class="netflix-button" type="password" name="password">
    </div>
    <div class="input-group">
        <button class="netflix-button" type="submit" name="submit" class="btn">Register</button>
    </div>
    
    <p>Already a member? <a href="login.php">Sign in</a></p>
</form>

        </div>
    </div>
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>

</html>