<?php
if(!isset($_SESSION['uid']))
{
    $userId = -1;
}
else
{
    $userId = $_SESSION['uid'];
}

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
        $returnData = $dbCon->GetRecipe($_GET['id'],$userId);

        if ($returnData['returnCode'] == 'e040')
        {
            $newRecipe = true;
            echo("ERROR 404 - Recipie not found!");
        }
        else
        {
            $newRecipe = false;
            
            if ($returnData['ownerId'] == $userId)
            {
                Include($modulePath."edit-recipe.php");
            }
            else
            {
                echo("ERROR 403 - ACCESS DENIED!");
            }
        }
    }
    else
    {
        $newRecipe = true;
        Include($modulePath."edit-recipe.php");
    }
    
}
else
{
    if (isset($_GET['id']))
    {
        $returnData = $dbCon->GetRecipeOnlyId($_GET['id']);

        if ($returnData['returnCode'] == 'e180')
        {
            echo("ERROR 404 - Recipie not found!");
        }
        else
        {
            if ($returnData['accessibility'] == 0)
            {
                if ($returnData['ownerId'] == $userId)
                {
                    Include($modulePath."view-recipe.php");
                }
                else
                {
                    echo("ERROR 403 - ACCESS DENIED!");
                }

            }
            else if ($returnData['accessibility'] == 1 || $returnData['accessibility'] == 2)
            {
                Include($modulePath."view-recipe.php");
            }
            else
            {
                echo("ERROR ### - Unknown error!");
            }
            
        }
    }
    else
    {
        echo("ERROR 404 - No recipe id!");
    }
    
}
        $dbCon->Close_Connection();
?>