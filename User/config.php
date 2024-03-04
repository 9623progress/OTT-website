<?php

// this configuration for google login
// i was using the composer find composer command of google login in official documentation-needed for vendor folder creation

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('your_client_id');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('your_secret_id');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/OTT/user/SignIn.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>