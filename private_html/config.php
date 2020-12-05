<?php
session_start();
require_once '../private_html/vendor/autoload.php';
$path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);

// init configuration
$clientID = '1052123898844-shrrjfm0l5lnn7atklutvfrhgcsrnvkk.apps.googleusercontent.com';
$clientSecret = 'oGQQ42ts4hdA2LAY6g2a-goN';
//$redirectUri = $path.'public_html/redirect.php';
$redirectUri = "https://18osfr.ssis.nu/GYProjekt/?page=redirect";
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

//:: HACKY WAKY :://
//$client->setApprovalPrompt('force');

$client->prompt="select_account";
$client->setIncludeGrantedScopes(true);