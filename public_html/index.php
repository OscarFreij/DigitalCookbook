<?php

require_once '../private_html/vendor/autoload.php';

require_once '../private_html/config.php';

$module_path = "../private_html/modules/";
$pages_path = "../private_html/pages/";
$vendor_path = "../private_html/vendor/";

$site_pre_url = "GYProjekt/"; // fix for a weird .htaccess bug... Talk to Daka!

$active_page = "";
$requireQuillJS = false;
$pagesRequieringQuillJS = ["0" =>  "recepie", "1" => "cookbook"];

/*
 * Variabels in use for page selection.
 * GET - page - Specified page, top selection.
 * GET - recipeID - Recipe identification string.
 * GET - search - search querry as URLEncoded JSON string.
 */

// Check what page we are on, else set to home.
if (isset($_GET['page']))
{
    $active_page = $_GET['page'];
    
    // Set $requireQuillJS to TRUE if the page is found inside $pagesRequieringQuillJS.
    foreach ($pagesRequieringQuillJS as $key => $value) {
        if ($value == $active_page)
        {
            $requireQuillJS = true;
            break;
        }
    }

    if ($active_page == "redirect")
    {
        require "../public_html/redirect.php";
        exit;
    }
    else if ($active_page == "logout")
    {
        require "../public_html/logout.php";
        exit;
    }
}
else
{
    $active_page = "home";
}

?>


<!DOCTYPE html>
<html lang="en">
<?php
// Require head.
Require $module_path."head.php";
?>
<body>
    <div id="wrapper">
        <?php
        // Require navbar.
        Require $module_path."navbar.php";
        ?>
        <div id="wrapper-content">
        <?php
        // Include the active page, currenty no 404 or 403 page :(
        Include $pages_path.$active_page.".php";
        ?>
        </div>
    </div>  
</body>
</html>



<?php

var_dump($_SESSION);