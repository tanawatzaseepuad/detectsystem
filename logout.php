<?php 
session_start();
require_once 'config.php';

// ตรวจสอบว่ามี Access Token ใน Session หรือไม่
if(isset($_SESSION['token']['access_token'])) {
    // ถ้ามี Access Token ให้เรียกเมธอด Revoke เพื่อทำลาย Access Token
    $client->revokeToken($_SESSION['token']['access_token']);
}

// Redirect ผู้ใช้ไปยัง Google Logout URL
$logoutURL = 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . $redirectURI;
header('Location: ' . filter_var($logoutURL, FILTER_SANITIZE_URL));
exit();
?>