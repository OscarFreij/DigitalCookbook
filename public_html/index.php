<?php

$module_path = "../private_html/modules/";
$pages_path = "../private_html/pages/";
$vendor_path = "../private_html/vendor/";



/*
 * Variabels in use for page selection.
 * GET - page - Specified page, top selection.
 * GET - recipeID - Recipe identification string.
 * GET - search - search querry as URLEncoded JSON string.
 */

?>


<!DOCTYPE html>
<html lang="en">
<?php
Require $module_path."head.php";
?>
<body>
<div id="wrapper">
    <?php
    Require $module_path."navbar.php";
    ?>
    <div id="wrapper-content">

    </div>
</div>
    

</body>
</html>