<div id="wrapper-main">
    <div id="wrapper-top">
        <span id="recipe_title">Recept Title</span>
        <div id="recipe_basicInfo">
            <span id="recipe_portions">Portioner: <span>0</span></span>
            <span id="recipe_time">Tillagnings tid: <span>0</span></span>
            <span id="recipe_difficulty">Svårighetsgrad: <span>0</span></span>
        </div>
        <div id="btnPanel1" class="btnPanel btn-group">
            <button class="btn btn-primary">Spara</button>
            <button class="btn btn-primary disabled">Lägg till i inköpslista</button>
            
            <?php
            if (isset($_SESSION['uid']))
            {
                if ($_SESSION['uid'] == $returnData['ownerId'])
                {
                    echo("<a href='".'?page=recipe&id='.$returnData['id'].'&edit=true'."' class='btn btn-primary'>Redigera</a>");
                }
            }
            ?>

        </div>
        <div>
            <span>Beskrivning</span>
            <div id="TT1">
                <p>Hello World!</p>
                <p>Some initial <strong>bold</strong> text</p>
                <p><br></p>
            </div>
        </div>
        <div>
            <span>Taggar</span>
            <div id="recipe_tags">

            </div>    
        </div>
        <div id="instructions-items">
            <span>Instruktioner</span>
            <div id="recipe_instructions">

            </div>
        </div>
    </div>
    <div id="wrapper-bottom">
        <div>
            <span>Servering</span>
            <div id="TB1">
                <p>Hello World!</p>
                <p>Some initial <strong>bold</strong> text</p>
                <p><br></p>
            </div>
        </div>    
        <div>
            <span>Tips</span>
            <div id="TB2">
                <p>Hello World!</p>
                <p>Some initial <strong>bold</strong> text</p>
                <p><br></p>
            </div>
        </div>
    </div>
</div>
<div id="wrapper-side">
    <img id="recipe_image" src="static/media/food.svg" alt="">
    <span>Ingredienser</span>   
    <div id="recipe_ingredients">

    </div>
    <div id="btnPanel2" class="btnPanel btn-group">
        <button class="btn btn-primary">Spara</button>
        <button class="btn btn-primary disabled">Lägg till i inköpslista</button>
        
        <?php
        if (isset($_SESSION['uid']))
        {
            if ($_SESSION['uid'] == $returnData['ownerId'])
            {
                echo("<a href='".'?page=recipe&id='.$returnData['id'].'&edit=true'."' class='btn btn-primary'>Redigera</a>");
            }
        }
        ?>
    </div>
</div>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>