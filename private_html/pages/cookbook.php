<div id="category_wrapper" class="list-group category_menu" data-menuisopen="true">
    <?php
    require_once("../private_html/db.class.php");

    $dbConn = new DB;
    $dbConn->Open_Connection();

    $returnData = $dbConn->GetCategories($_SESSION['uid']);
    if (isset($returnData['categories']))
    {
        foreach ($returnData['categories'] as $key => $row) {
            echo($row);
        }
    }
    else
    {
        echo("<p>Här var det tomt. Pröva att skapa några fler kategorier via knappen nedan!</p>");
    }
    ?>

    
</div>
<div id="content_wrapper" class="list-group" style="overflow-y: auto;">
    <?php
        if (isset($_GET['category']))
        {
            $returnData = $dbConn->GetAllUserRecipeRelatios($_SESSION['uid']);

            if ($returnData['returnCode'] == "s160")
            {
                foreach ($returnData['relations'] as $key => $value) {
                    if ($value['folderId'] == $_GET['category'])
                    {
                        $response = $dbConn->GetRecipeRowCookBook($value['recipeId']);
                        if ($response['returnCode'] == "s170")
                        {
                            echo($response['row']);
                        }
                    }
                }
            }
            else if ($returnData['returnCode'] == "s161")
            {
                echo("No relations found!");
            }
            else
            {
                echo("An error was returned by the server, Contact admin with error code \"e160\"");
            }
        }

        $dbConn->Close_Connection();
    ?>
</div>
<div id="edit_wrapper" class="btn-group category_menu" data-menuisopen="true">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddCategoryModal">Lägg till kategori</button>
    <button type="button" class="btn btn-warning" id="ToggleEditBtn" onClick="ToggleEdit()">Ändra</button>
    <button type="button" class="btn btn-primary" id="ToggleMenuBtn" onClick="ToggleMenu()">Toggla menyn</button>
</div>

<div id="bottom_wrapper" class="btn-group">
    <a class="btn btn-primary" id="AddRecepieBtn" href="/<?=$sitePreURL?>?page=recipe&edit=true"><p>Lägg till recept</p></a>
</div>

