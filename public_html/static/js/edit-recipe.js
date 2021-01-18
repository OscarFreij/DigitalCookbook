var EditorArray = Array();
var toolbarOptions = [[{ size: [ 'small', false, 'large', 'huge' ]}],['bold', 'italic']];
var imageData = "";
var recipeObject = new Object();
var updateRecipe = false;
var responsDATA;

document.addEventListener("DOMContentLoaded", function()
{
    GetImage();
    EditQuill();

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
}

function GetQuillContent()
{
    var dataArray = Array();
    EditorArray.forEach(element => {
        dataArray.push(btoa(encodeURIComponent(JSON.stringify(element.getContents()))));
    });
    return dataArray;
}

function SetQuillContent(QUIL_JSON) {
    
    for (let i = 0; i < EditorArray.length; i++) {
        EditorArray[i].setContents(JSON.parse(decodeURIComponent(atob(QUIL_JSON[i]))));
    }
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
        case "0":
            $('#recipe_difficulty_fast')[0].checked = true;
            break;
        case "1":
            $('#recipe_difficulty_basic')[0].checked = true;
            break;
        case "2":
            $('#recipe_difficulty_avrage')[0].checked = true;
            break;
        case "3":
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
    
    /*
        'instructions' => $recipeData[0]['instructions'],
    */
    

    
}

function AddRowIngredients($data = null)
{
    var row = document.createElement("div");
    row.classList.add("tRow");

    row.appendChild(document.createElement("div"));
    row.appendChild(document.createElement("div"));
    row.appendChild(document.createElement("div"));
    
    for (let i = 0; i < row.children.length; i++) {
        const element = row.children[i];
        element.classList.add("tRowItem");
        element.appendChild(document.createElement("input"));
        element.children[0].setAttribute("type", "text");
        
        if ($data != null)
        {
            switch (i) {
                case 0:
                    element.children[0].value = $data.amount;
                    break;
                case 1:
                    element.children[0].value = $data.amountType;
                    break;
                case 2:
                    element.children[0].value = $data.name;
                    break;
            }
        }
        else
        {
            console.log("AddingEmptyRow");
        }
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

function AddRowHowTo($data = null)
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
    
    if ($data != null)
    {
        row.children[1].value = $data.amountType;
    }

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
            var b64 = reader.result;
            imageData = b64;
            
            if ($('#container_img')[0].children[$('#container_img')[0].children.length-1].nodeName == "IMG")
            {
                $('#container_img')[0].children[$('#container_img')[0].children.length-1].src = imageData;
            }
            else
            {
                $('#container_img')[0].appendChild(document.createElement("img"));
                $('#container_img')[0].children[$('#container_img')[0].children.length-1].src = imageData;
                $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.width = "288px";
                $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.height = "288px";
                $('#container_img')[0].children[$('#container_img')[0].children.length-1].style.alignSelf = "center";
            }
            
            
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
    if (imageData != "")
    {
        object.imageData = btoa(encodeURIComponent(imageData));
    }
    
    
    try
    {
        id = GetURLID();
        
        if(id != false)
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

    object.accessibility = $('#recipe_accessibility')[0].value;
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
            
            responseJSON = JSON.parse(this.response);

            if (typeof responseJSON.id !== 'undefined')
            {
                location.href = window.location.href.substr(0,window.location.href.length - window.location.search.length) + "/?page=recipe&id=" + responseJSON.id;
            }
            else
            {
                console.error("Recipe ID not returned.");
            }
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