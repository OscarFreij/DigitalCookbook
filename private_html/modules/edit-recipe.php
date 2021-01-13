<div id="wrapper-main">
    <div id="container_title">
        <h2>Titel</h2>
        <form>
        <input type="text" name="recipe_title" id="recipe_title">
        </form>
    </div>
    <div id="container_img">
        <h2>Bild</h2>
        <form>
        <input type="file" name="recipe_picture" id="recipe_picture">
        </form>
    </div>
    <div id="container_portions">
        <h2>Antal portioner</h2>
        <form>
            <input type="number" name="recipe_portions" id="recipe_portions">
        </form>
        <h2>Skalbar</h2>
        <form>
            <input type="radio" name="recipe_scalable" id="recipe_scalable_yes">
            <lable>: Ja </lable>
            <lable> | </lable>
            <lable> Nej :</lable>
            <input type="radio" name="recipe_scalable" id="recipe_scalable_no">
        </form>
    </div>
    <div id="container_time">
        <h2>Tid</h2>
        <form>
            <input type="number" name="recipe_time" id ="recipe_time">
            <lable> : min</lable>
        </form>
    </div>
    <div id="container_ingredients">
        <h2>Ingredienser</h2>
        <div id ="recipe_ingredients">
            <div class="tRow"><div class="tRowItem">Mängd</div><div class="tRowItem">Enhet</div><div class="tRowItem">Ingridiens</div></div>
            <div class="tRow"><div class="tRowItem"><input type="text"></div><div class="tRowItem"><input type="text"></div><div class="tRowItem"><input type="text"></div></div>
        </div>
        <div class="btn-group">
            <button class="btn btn-primary" onClick="AddRowIngredients()">Lägg till</button>
            <button class="btn btn-danger" onClick="RemoveRowIngredients()">Ta bort</button>
        </div>
    </div>
    <div id="container_howto">
        <h2>Gör så här</h2>
        <div id ="recipe_howto">
            <div class="tRow"><div class="tRowItem">1</div><div class="tRowItem"><input type="text"></div></div>
        </div>
        <div class="btn-group">
            <button class="btn btn-primary" onClick="AddRowHowTo()">Lägg till</button>
            <button class="btn btn-danger" onClick="RemoveRowHowTo()">Ta bort</button>
        </div>
    </div>
    <div id="container_description">
        <h2>Beskrivning av rätten</h2>
        <div id="TT1">
            <p>beskrivning av din rätt</p>
        </div>
    </div>
    <div id="container_tags">
        <h2>Taggar</h2>
        <form id="recipe_tags">
            <?php
                $returnData = $dbCon->GetTagsEdit(0);
                foreach ($returnData['tags'] as $key => $value) {
                    echo($value);
                }
            ?>
        </form>
    </div>
    <div id="container_equipment">
        <h2>Vitvaror</h2>
        <form id="recipe_equipment">
            <?php
                $returnData = $dbCon->GetTagsEdit(1);
                foreach ($returnData['tags'] as $key => $value) {
                    echo($value);
                }
            ?>
        </form>
    </div>
    <div id="container_difficulty">
        <h2>Svårighetsgrad</h2>
        <form id="recipe_difficulty">
            <div>
                <input type="radio" name="recipe_difficulty" id="recipe_difficulty_fast"><label for="recipe_difficulty_fast">: Snabb</label>
            </div>
            <div>
                <input type="radio" name="recipe_difficulty" id="recipe_difficulty_basic"><label for="recipe_difficulty_basic">: Basic</label>
            </div>
            <div>
                <input type="radio" name="recipe_difficulty" id="recipe_difficulty_avrage"><label for="recipe_difficulty_avrage">: Normal</label>
            </div>
            <div>
                <input type="radio" name="recipe_difficulty" id="recipe_difficulty_advanced"><label for="recipe_difficulty_advanced">: Avancerad</label>
            </div>
        </form>
    </div>
    <div id="container_serving">
        <h2>Servering</h2>
        <div id="TB1">
            <p>Hur serveras rätten</p>
        </div>
    </div>
    <div id="container_tips">
        <h2>Tips</h2>
        <div id="TB2">
            <p>Ge tipps om rätten</p>
        </div>
    </div>
    <div id="container_accessibility">
        <h2>Tillgänglighet</h2>
        <div>
            <lable>Tillgänglighet för andra :</lable>
            <select name="recipe_accessibility" id="recipe_accessibility">
                <option value="0">Privat</option>
                <option value="1">Olistad</option>
                <option value="2">Publik</option>
            </select>
        </div>
    </div>
    <div id="container_category">
        <h2>Plats</h2>
        <div>
            <lable>Kapitel i kokboken :</lable>
            <select name="recipe_category" id="recipe_category">
                <?php
                    $returnData = $dbCon->GetCategoriesForSelection($_SESSION['uid']);
                    foreach ($returnData['categories'] as $key => $value) {
                        echo($value);
                    }
                ?>
            </select>
        </div>
    </div>
    <div>
        <button id="saveBtn" class="btn btn-success" onClick="SaveRecipe()">Spara</button>
    </div>
</div>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>