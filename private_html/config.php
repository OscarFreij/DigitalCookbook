<?php
session_start();
require_once '../private_html/vendor/autoload.php';
$path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);

$accessFilePath = "../private_html/client_secret.json";

try
{
    $myfile = fopen($accessFilePath, "r") or die("Unable to open file!");
    $fileContent = fread($myfile,filesize($accessFilePath));
    fclose($myfile);

    $data = json_decode($fileContent, true)['web'];

    // init configuration
    $clientID = $data['client_id'];
    $clientSecret = $data['client_secret'];
    $redirectUri = "https://18osfr.ssis.nu/GYProjekt/?page=redirect";

}
catch (Exeptiopn $e)
{
    echo "Error: $e";
}

  
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