<?php 

session_start();

if (isset($_POST['email'])) { // ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่

    include('sever.php');

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_enc = md5($password);

    $query = "SELECT * FROM userdata WHERE email = '$email' AND password = '$password_enc'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result); 

        $_SESSION['emailid'] = $row['id'];
        $_SESSION['firstname'] = $row['firstname'] ;
        $_SESSION['userlevel'] = $row['userlevel'];

    if ($_SESSION['userlevel'] == 'admin') {
        header("Location: admin_page.php");
        
    } elseif ($_SESSION['userlevel'] == 'officer') {
        header("Location: user_page.php");
        
    } elseif ($_SESSION['userlevel'] == 'null') {
        header("Location: nomember.php");
        
    }
    
} else {
    echo "<script>alert('Invalid username or password');</script>";
    // หรือสามารถใช้ $_SESSION['error'] = "Invalid username or password"; แล้ว redirect ไปยังหน้า login ได้
    echo "<script>window.location.href = 'login.php';</script>";
} 
} else {
    header("Location: login.php");
}
if(empty($_SESSION['userlevel'])) {
    header("Location: nomember.php");
    exit(); // ออกจากการทำงานหลังจาก redirect
}

?>

