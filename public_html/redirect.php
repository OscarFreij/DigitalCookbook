<?php
    require_once '../private_html/config.php';
    require_once '../private_html/db.class.php';
    $dbCon = new DB;

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

    var_dump($google_account_info);
    
    /*
    $dbCon->Open_Connection();
    $user_info = $dbCon->getUserInfoEmail($_SESSION['email']);

    if (isset($user_info['email']))
    {
        $_SESSION['id'] = $user_info['id'];
        $_SESSION['email'] =  $user_info['email'];
        $_SESSION['nickname'] =  $user_info['nickname'];
        
        if (isset($user_info['given_name']))
        {
            $_SESSION['given_name'] =  $user_info['first_name'];
        }
        
        if (isset($user_info['family_name']))
        {
            $_SESSION['family_name'] = $user_info['family_name'];
        }

        if (isset($user_info['picture']))
        {
            $_SESSION['picture'] = $user_info['picture'];
        }

        $_SESSION['locale'] = $user_info['locale'];
        $_SESSION['admin_level'] = $user_info['admin_level'];
    }
    else
    {
        $tempNick = $dbCon->createUser($_SESSION['email'],$_SESSION['given_name'],$_SESSION['family_name'],$_SESSION['locale']);
        $_SESSION['admin_level'] = 0;
        $_SESSION['nickname'] = $tempNick;
    }

    // update picture link

    $status = $dbCon->updateUser("profile_picture", $_SESSION['profile_picture'], $_SESSION['email']);

    */

    $dbCon->Close_Connection();
    header('Location: '.$path); 
    exit();
?>