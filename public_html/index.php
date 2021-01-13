<?php

require_once '../private_html/vendor/autoload.php';

require_once '../private_html/config.php';

$modulePath = "../private_html/modules/";
$pagesPath = "../private_html/pages/";
$vendorPath = "../private_html/vendor/";

$sitePreURL = "GYProjekt/"; // fix for a weird .htaccess bug... Talk to Daka!

$activePage = "";
$requireQuillJS = false;
$pagesRequieringQuillJS = ["0" =>  "recipe"];
$pagesRequieringSignIn = ["0" => "account", "1" => "cookbook", "2" => "settings"];

/*
 * Variabels in use for page selection.
 * GET - page - Specified page, top selection.
 * GET - recipeID - Recipe identification string.
 * GET - search - search querry as URLEncoded JSON string.
 */

// Check what page we are on, else set to home.
if (isset($_GET['page']))
{
    $activePage = $_GET['page'];
    
    // Set $requireQuillJS to TRUE if the page is found inside $pagesRequieringQuillJS.
    foreach ($pagesRequieringQuillJS as $key => $value) {
        if ($value == $activePage)
        {
            $requireQuillJS = true;
            break;
        }
    }

    if ($activePage == "redirect")
    {
        require "../public_html/redirect.php";
        exit;
    }
    else if ($activePage == "logout")
    {
        require "../public_html/logout.php";
        exit;
    }

    foreach ($pagesRequieringSignIn as $key => $value) {
        if ($value == $activePage)
        {
            if (!isset($_SESSION['email']))
            {
                $activePage = "askToLogin";
                break;
            }
        }
    }
}
else
{
    $activePage = "home";
}

?>


<!DOCTYPE html>
<html lang="en">
<?php
// Require head.
Require $modulePath."head.php";
?>
<body>
    <div id="wrapper">
        <?php
        // Require navbar.
        Require $modulePath."navbar.php";
        ?>
        <div id="wrapper-content">
        <?php
        // Include the active page, currenty no 404 or 403 page :(
        Include $pagesPath.$activePage.".php";
        ?>
        </div>
        <?php
        if (file_exists($modulePath."modal-".$activePage.".php"))
        {
            include $modulePath."modal-".$activePage.".php";
        }
        ?>
    </div>  
    
</body>
</html>