<?php
    require_once '../private_html/config.php';
    require_once '../private_html/db.class.php';
    $dbConn = new DB;

    //$path = ($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST']);
    $path = "https://18osfr.ssis.nu/GYProjekt/?page=home";

    // authenticate code from Google OAuth Flow
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    }
    else if (isset($_SESSION['access_token']))
    {
        $client->setAccessToken($_SESSION['access_token']);
    }
    else
    {
        header('Location: '.$path); 
        exit;
    }

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $_SESSION['id'] = $google_account_info->id;
    $_SESSION['email'] =  $google_account_info->email;
    $_SESSION['given_name'] =  $google_account_info->given_name;
    $_SESSION['family_name'] = $google_account_info->family_name;
    $_SESSION['picture'] = $google_account_info->picture;
    $_SESSION['locale'] = $google_account_info->locale;
    $_SESSION['profile_picture'] = $google_account_info->picture;
    
    
    $dbConn->Open_Connection();

    $user_info = $dbConn->GetUserDetailsByEmail($_SESSION['email']);
    
    if ($user_info['returnCode'] == 'e102')
    {
        $user_info = $dbConn->CreateAccount($_SESSION['email']);
        
        $_SESSION['uid'] = $user_info['id'];
        $_SESSION['admin_level'] = 0;
    }
    else
    {
        $_SESSION['uid'] = $user_info['id'];
        $_SESSION['admin_level'] = $user_info['admin'];
    }

    $dbConn->Close_Connection();
    header('Location: '.$path); 
    exit();
?>