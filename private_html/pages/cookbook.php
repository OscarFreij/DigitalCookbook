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

    $dbConn->Close_Connection();
    ?>

    
</div>
<div id="content_wrapper" style="overflow-y: auto;">
    
</div>
<div id="edit_wrapper" class="btn-group category_menu" data-menuisopen="true">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddCategoryModal">Add Category</button>
    <button type="button" class="btn btn-warning" id="ToggleEditBtn" onClick="ToggleEdit()">Edit</button>
    <button type="button" class="btn btn-primary" id="ToggleMenuBtn" onClick="ToggleMenu()">Toggle Menu</button>
</div>

<div id="bottom_wrapper" class="btn-group">
    <a class="btn btn-primary" id="AddRecepieBtn" href="/<?=$sitePreURL?>?page=recipe&edit=true"><p>Add Recipe</p></a>
</div>

