<?php 
//start session
session_start();
require_once 'config.php';

if (isset($_GET['code'])) {
   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
   $client->setAccessToken($token);

   // getting user profile
   $gauth = new Google_Service_Oauth2($client);
   $google_info = $gauth->userinfo->get();

   $_SESSION['info'] = [
      'name' => $google_info->name, 
      'email' => $google_info->email, 
      'picture' => $google_info->picture
   ];
   header('Location: /register/nomember.php');
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons    ">

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
        <button type="button" class="login-link">Login</button>
</div>
    </div>
    <div class="main-box">
    <div class="header">
    <h2>Login</h2>
</div>

    <form action="logindata.php" method="post">
        <label for="email">Email</label>
        <input class="netflix-button" type="text" name="email" placeholder="Email" required>
        <br>
        <label for="password">Password</label>
        <input class="netflix-button" type="password" name="password" placeholder="Password" required>
        <br>
        <input type="submit" name="submit" value="Login" class="netflix-button">
        <a href="register.php">Go to register</a>
    </form>
        
    
    
   
    <div class="container4">
    <a href="<?= $client->createAuthUrl()?>" class="btn btn-primary google-login">
        
        Login with Google
    </a>
</div>
  
   
        
    </div>
    <!-- <script src="script.js"></script> -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> -->
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>
</html>