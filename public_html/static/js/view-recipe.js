var EditorArray = Array();
var responsDATA;

document.addEventListener("DOMContentLoaded", function()
{
    ViewQuill();

    if (GetURLID() != false)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                PutContent(JSON.parse(this.response));
                responsDATA = JSON.parse(this.response);
           }
        };
        xhttp.open("POST", "callback.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=GetRecipe&id="+GetURLID());
    }
}
);


function ViewQuill()
{
    quill = new Quill('#TT1', {
        theme: 'bubble',
        modules:{
            toolbar: false
        },
        readOnly: true
    });
    EditorArray.push(quill);

    quill = new Quill('#TB1', {
        theme: 'bubble',
        modules:{
            toolbar: false
        },
        readOnly: true
    });
    EditorArray.push(quill);

    quill = new Quill('#TB2', {
        theme: 'bubble',
        modules:{
            toolbar: false
        },
        readOnly: true
    });
    EditorArray.push(quill);
}

function SetQuillContent(QUIL_JSON) {
    
    for (let i = 0; i < EditorArray.length; i++) {
        EditorArray[i].setContents(JSON.parse(decodeURIComponent(atob(QUIL_JSON[i]))));
    }
}

function GetURLID()
{
    var searchString = "id=";
    var searchString2 = "&edit=";
    var url = window.location.href;
    var startPos = url.indexOf(searchString)+searchString.length;
    var startPos2 = url.indexOf(searchString2);
    var length = startPos2-startPos;
    var id = url.substr(startPos,length);
    
    if (!isNaN(id))
    {
        return id;
    }
    else
    {
        return false;
    }
}

function PutContent($recipeObject) {
    

    updateRecipe = true;

    if (typeof($recipeObject.picture) != "undefined")
    {
        $('#container_img')[0].appendChild(document.createElement("img"));
        $('#container_img')[0].children[$('#container_img')[0].children.length-1].src = decodeURIComponent(atob($recipeObject.picture));
        $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.width = "288px";
        $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.height = "288px";
        $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.alignSelf = "center";
        imageData = decodeURIComponent(atob($recipeObject.picture));
    }

    $('#recipe_title')[0].value = $recipeObject.name;
    $('#recipe_portions')[0].value = $recipeObject.portions;
    
    
    if ($recipeObject.scalable == 1)
    {
        $('#recipe_scalable_yes')[0].checked = true;
    }
    else
    {
        $('#recipe_scalable_no')[0].checked = true;
    }

    $('#recipe_time')[0].value = $recipeObject.time;

    switch ($recipeObject.difficulty) {
        case 0:
            $('#recipe_difficulty_fast')[0].checked = true;
            break;
        case 1:
            $('#recipe_difficulty_basic')[0].checked = true;
            break;
        case 2:
            $('#recipe_difficulty_avrage')[0].checked = true;
            break;
        case 3:
            $('#recipe_difficulty_advanced')[0].checked = true;
            break;
    }
    
    $('#recipe_accessibility')[0].value = $recipeObject.accessibility;
    
    $('#recipe_category')[0].value = $recipeObject.relationsData.relations.folderId;

    var QuillArray = Array($recipeObject.description, $recipeObject.serving, $recipeObject.tips);

    SetQuillContent(QuillArray);

    var tagsElementArray = Array();

    for (let i = 0; i < $('#recipe_tags')[0].children.length; i++) {
        const element = $('#recipe_tags')[0].children[i];
        tagsElementArray.push(element);
    }

    for (let i = 0; i < $('#recipe_equipment')[0].children.length; i++) {
        const element = $('#recipe_equipment')[0].children[i];
        tagsElementArray.push(element);
    }

    for (let i = 0; i < tagsElementArray.length; i++) {
        const element = tagsElementArray[i].children[0];
        for (let j = 0; j < JSON.parse($recipeObject.tags).length; j++) {
            const element_2 = JSON.parse($recipeObject.tags)[j];
            
            if (element.value == element_2)
            {
                element.checked = true;
            }
        }
    }

    var ingredients = JSON.parse($recipeObject.ingredients);
    for (let i = 0; i < ingredients.length; i++) {
        const element = ingredients[i];
        if (i == 0)
        {
            $('#recipe_ingredients')[0].children[1].children[0].children[0].value = element.amount;
            $('#recipe_ingredients')[0].children[1].children[1].children[0].value = element.amountType;
            $('#recipe_ingredients')[0].children[1].children[2].children[0].value = element.name;
        }
        else
        {
            AddRowIngredients(element);
        }
    }

    var instructions = JSON.parse($recipeObject.instructions);
    for (let i = 0; i < instructions.length; i++) {
        const element = instructions[i];
        if (i == 0)
        {
            $('#recipe_howto')[0].children[0].children[1].children[0].value = element.amountType;
        }
        else
        {
            AddRowHowTo(element);
        }
    }
}