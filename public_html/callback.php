<?php
    require_once("../private_html/db.class.php");

    session_start();
    //
    //var_dump($idea);

    $dbCon = new db;
    $dbCon->connectToDB();
    
    $numberOfIdeas = $dbCon->getPostAmount(true);
    //echo $numberOfIdeas;
    if (isset($_GET["LastPostLimit"]) && isset($_GET["AmountToLoad"]) && !isset($_GET['idea']))
    {
        //echo $numberOfIdeas;
        echo($dbCon->getPosts($_GET['LastPostLimit'],$_GET["AmountToLoad"],$_SESSION['id']));
    }
    elseif (isset($_GET['idea']) && !isset($_GET["LastPostLimit"]) && !isset($_GET["AmountToLoad"]) && !isset($_GET['FollowAction']))
    {
        echo(($dbCon->getPostDescription($_GET['idea'], $_SESSION['id'])));   
    }
    elseif (isset($_GET['FollowAction']) && isset($_GET['TargetType']) && isset($_GET['TargetID']))
    {
        if ($_GET['FollowAction'] == "Status")
        {
            return $dbCon->checkIfFollow($_SESSION['id'],$_GET['TargetType'],$_GET['TargetID']);
        }
        elseif ($_GET['FollowAction'] == "Toggle")
        {
            $dbCon->toggleFollow($_SESSION['id'],$_GET['TargetType'],$_GET['TargetID']);
        }
    }
    elseif (isset($_GET['remove']))
    {
        $dbCon->deletePost($_GET['remove'],$_SESSION['id']);
    }
    else
    {
        echo("Failed to execute task!");
    }

    $dbCon->closeConn();

?>