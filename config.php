<?php
require_once 'vendor/autoload.php';

$clientID = '402943900646-7iu8cfbrike7u4utij1b5cmo3d6219cc.apps.googleusercontent.com';
$clientSecret = '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';
$redirectURI = 'http://localhost/register/login.php';

// CREATE CLIENT REQUEST TO GOOGLE
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectURI);
$client->addScope('profile');
$client->addScope('email');