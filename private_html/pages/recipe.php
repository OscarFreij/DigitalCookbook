<?php

if(isset($_GET['edit']))
{
    if($_GET['edit'] == "true")
    {
        $EditMode = true;
    }
    else if($_GET['edit'] == "false")
    {
        $EditMode = false;
    }
    else
    {
        $EditMode = false;
    }
}
else
{
    $EditMode = false;
}

require_once("../private_html/db.class.php");
$dbCon = new db;
$dbCon->Open_Connection();

if ($EditMode)
{
    

    if (isset($_GET['id']))
    {
        $returnData = $dbCon->GetRecipe($_GET['id'],$_SESSION['uid']);

        if ($returnData['returnCode'] == 'e202')
        {
            $newRecipe = true;
        }
        else
        {
            $newRecipe = false;
        }
    }
    else
    {
        $newRecipe = true;
    }

    Include($modulePath."edit-recipe.php");
}
else
{
    if (isset($_GET['id']))
    {
        $returnData = $dbCon->GetRecipe($_GET['id'],$_SESSION['uid']);

        if ($returnData['returnCode'] == 'e202')
        {
            echo("ERROR 404 - Recipie not found!");
        }
        else
        {
            Include($modulePath."view-recipe.php");
        }
    }
    else
    {
        echo("ERROR 404 - No recipe id!");
    }
    
}
        $dbCon->Close_Connection();
?>