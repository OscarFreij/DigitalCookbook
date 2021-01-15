<?php
    require_once("../private_html/db.class.php");

    session_start();

    $dbCon = new db;
    $dbCon->Open_Connection();

    if (isset($_POST['action']))
    {
        switch ($_POST['action']) {
            case 'AddCategory':
                echo($dbCon->CreateCategory($_POST['name'], $_POST['nextId']));
                break;

            case 'RemoveCategory':
                echo($dbCon->RemoveCategory($_POST['id']));
                break;

            case 'UpdateCategories':
                echo($dbCon->UpdateCategories($_POST['JSON_Categories']));
                break;

            case 'GetRecipe':
                echo($dbCon->GetRecipe($_POST['id'], $_SESSION['uid']));
                break;

            case 'CreateRecipe':
                echo($dbCon->CreateRecipe(json_decode($_POST['JSON_RecipeData']), $_SESSION['uid']));
                break;
            default:
                # code...
                break;
        }
    }

    $dbCon->Close_Connection();

?>