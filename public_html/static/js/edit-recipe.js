var EditorArray = Array();
var toolbarOptions = [[{ size: [ 'small', false, 'large', 'huge' ]}],['bold', 'italic']];
var imageData = "";
var recipeObject = new Object();
var updateRecipe = false;

document.addEventListener("DOMContentLoaded", function()
{
    GetImage();
    EditQuill();
}
);


function EditQuill() 
{    
    quill = new Quill('#TT1', {
        theme: 'snow',
        modules:{
            toolbar: toolbarOptions
        }
    });
    EditorArray.push(quill);

    quill = new Quill('#TB1', {
        theme: 'snow',
        modules:{
            toolbar: toolbarOptions
        }
    });
    EditorArray.push(quill);

    quill = new Quill('#TB2', {
        theme: 'snow',
        modules:{
            toolbar: toolbarOptions
        }
    });
    EditorArray.push(quill);
    PutContent();
}

function GetQuillContent()
{
    var dataArray = Array();
    EditorArray.forEach(element => {
        dataArray.push(element.getContents());
    });
    return dataArray;
}

function SetQuillContent(QUIL_JSON) {
    
}

function ConvertContentToJSON() {
    var returnData = Array();

}

function GetURLID()
{
    var searchString = "id=";
    var searchString2 = "&edit=";
    var url = window.location.href;
    var startPos = url.indexOf(searchString)+searchString.length;
    var startPos2 = url.indexOf(searchString2);
    var lenght = startPos2-startPos;
    var id = url.substr(startPos,lenght);
    
    if (id.lenght > 0)
    {
        return id;
    }
    else
    {
        return false;
    }
}

function PutContent() {
    
}

function AddRowIngredients()
{
    var row = document.createElement("div");
    row.classList.add("tRow");

    row.appendChild(document.createElement("div"));
    row.appendChild(document.createElement("div"));
    row.appendChild(document.createElement("div"));
    
    for (let i = 0; i < row.children.length; i++) {
        const element = row.children[i];
        element.classList.add("tRowItem");
        element.appendChild(document.createElement("input"))
        element.children[0].setAttribute("type", "text");
    }

    $('#recipe_ingredients')[0].appendChild(row);
}

function RemoveRowIngredients()
{
    if ($('#recipe_ingredients')[0].children.length > 2)
    {
        var id = $('#recipe_ingredients')[0].children.length;
        $('#recipe_ingredients')[0].children[parseInt(id)-1].remove();
    }
}

function AddRowHowTo()
{
    var row = document.createElement("div");
    row.classList.add("tRow");

    row.appendChild(document.createElement("div"));
    row.appendChild(document.createElement("div"));
    
    row.children[0].classList.add("tRowItem");
    row.children[0].innerText = parseInt($('#recipe_howto')[0].children[parseInt($('#recipe_howto')[0].children.length)-1].innerText)+1

    row.children[1].classList.add("tRowItem");
    row.children[1].appendChild(document.createElement("input"))
    row.children[1].setAttribute("type", "text");

    $('#recipe_howto')[0].appendChild(row);
}

function RemoveRowHowTo()
{
    if ($('#recipe_howto')[0].children.length > 1)
    {
        var id = $('#recipe_howto')[0].children.length;
        $('#recipe_howto')[0].children[parseInt(id)-1].remove();
    }
}


function GetImage() {
    input = $('#recipe_picture')[0]
    input.onchange = function () {
        var file = input.files[0],
          reader = new FileReader();
      
        reader.onloadend = function () {
            var b64 = reader.result;//.replace(/^data:.+;base64,/, '');
            imageData = b64;
        };
      
        reader.readAsDataURL(file);
    };
}

function SaveRecipe()
{
    ProcessRecipe();
    SendToServer();
}

function ProcessRecipe() {
    
    var object = new Object();
    object.title = $('#recipe_title')[0].value;
    object.imageData = imageData;
    
    try
    {
        var searchString = "id=";
        var searchString2 = "&edit=";
        var url = window.location.href;
        var startPos = url.indexOf(searchString)+searchString.length;
        var startPos2 = url.indexOf(searchString2);
        var lenght = startPos2-startPos;
        var id = url.substr(startPos,lenght);
        
        if(id.lenght > 0)
        {
            object.id = id;
            updateRecipe = true;
        }
        else
        {
            updateRecipe = false;
        }
    }
    catch (error)
    {
        
    }

    object.portions = $('#recipe_portions')[0].value;
    
    if ($('#recipe_scalable_yes')[0].checked == true)
    {
        object.scalable = 1;
    }
    else if ($('#recipe_scalable_no')[0].checked == true)
    {
        object.scalable = 1;
    }
    else
    {
        object.scalable = 0;
    }
    
    object.time = $('#recipe_time')[0].value

    var ingredients = Array();
    var ingredientsCollection = $('#recipe_ingredients').find('.tRow');
    for (let i = 1; i < ingredientsCollection.length; i++) {
        const element = ingredientsCollection[i];
        var ingredientRow = new Object();
        ingredientRow.amount = element.children[0].children[0].value;
        ingredientRow.amountType = element.children[1].children[0].value;
        ingredientRow.name = element.children[2].children[0].value;

        ingredients.push(ingredientRow);
    }
    object.ingredients = ingredients;

    var howTo = Array();
    var howToCollection = $('#recipe_howto').find('.tRow');
    for (let i = 0; i < howToCollection.length; i++) {
        const element = howToCollection[i];
        var howToRow = new Object();
        howToRow.amount = element.children[0].innerText;
        howToRow.amountType = element.children[1].children[0].value;

        howTo.push(howToRow);
    }
    object.howTo = howTo;

    var quillData = GetQuillContent();

    object.description = quillData[0];
    object.serving = quillData[1];
    object.tips = quillData[2];

    var tagsArray = Array();
    var tagsCollection = $('#recipe_tags')[0].children;
    var equipmentCollection = $('#recipe_equipment')[0].children;
    
    for (let i = 0; i < tagsCollection.length; i++) {
        const element = tagsCollection[i];
        if (element.children[0].checked == true)
        {
            var id = element.children[0].value;
            tagsArray.push(id);
        }
    }

    for (let i = 0; i < equipmentCollection.length; i++) {
        const element = equipmentCollection[i];
        if (element.children[0].checked == true)
        {
            var id = element.children[0].value;
            tagsArray.push(id);
        }
    }

    object.tags = tagsArray;
    
    if ($('#recipe_difficulty_fast')[0].checked == true)
    {
        object.difficulty = 0;
    }
    else if ($('#recipe_difficulty_basic')[0].checked == true)
    {
        object.difficulty = 1;
    }
    else if ($('#recipe_difficulty_avrage')[0].checked == true)
    {
        object.difficulty = 2;
    }
    else if ($('#recipe_difficulty_advanced')[0].checked == true)
    {
        object.difficulty = 3;
    }

    object.status = $('#recipe_status')[0].value;
    object.category = $('#recipe_category')[0].value;

    recipeObject = object;
}

function SendToServer($debugMessage = null)
{
    if (updateRecipe)
    {
        action = "UpdateRecipe";
    }
    else
    {
        action = "CreateRecipe";
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
       }
    };
    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if ($debugMessage != null)
    {
        xhttp.send("action="+action+"&JSON_RecipeData="+$debugMessage);
    }
    else
    {
        xhttp.send("action="+action+"&JSON_RecipeData="+JSON.stringify(recipeObject));   
    }
}