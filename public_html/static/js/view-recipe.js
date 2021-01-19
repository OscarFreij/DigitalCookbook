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
                responsDATA = JSON.parse(this.response);
                PutContent(JSON.parse(this.response));
           }
        };
        xhttp.open("POST", "callback.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=GetRecipeOnlyID&id="+GetURLID());
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
    if (startPos2 = -1)
    {
        var length = url.length-startPos;
        var id = url.substr(startPos,length);
    }
    else
    {
        var length = startPos2-startPos;
        var id = url.substr(startPos,length);
    }
    
    if (!isNaN(id))
    {
        return id;
    }
    else
    {
        return false;
    }
}

function PutContent($recipeObject)
{
    if (typeof($recipeObject.picture) != "undefined" && $recipeObject.picture != "")
    {
        $('#recipe_image')[0].src = decodeURIComponent(atob($recipeObject.picture));
        $('#recipe_image')[0].style.width = "288px";
        $('#recipe_image')[0].style.height = "288px";
        $('#recipe_image')[0].style.alignSelf = "center";
        imageData = decodeURIComponent(atob($recipeObject.picture));
    }

    $('#recipe_title')[0].innerText = $recipeObject.name;
    $('#recipe_portions')[0].children[0].innerText = $recipeObject.portions;
    
    /*
    if ($recipeObject.scalable == 1)
    {
        $('#recipe_scalable_yes')[0].checked = true;
    }
    else
    {
        $('#recipe_scalable_no')[0].checked = true;
    }
    */
   
    $('#recipe_time')[0].value = $recipeObject.time;

    switch ($recipeObject.difficulty) {
        case 0:
            $('#recipe_difficulty')[0].children[0].innerText = "Snabb";
            break;
        case 1:
            $('#recipe_difficulty')[0].children[0].innerText = "Basic";
            break;
        case 2:
            $('#recipe_difficulty')[0].children[0].innerText = "Normal";
            break;
        case 3:
            $('#recipe_difficulty')[0].children[0].innerText = "Advancerad";
            break;
    }
    
    var QuillArray = Array($recipeObject.description, $recipeObject.serving, $recipeObject.tips);

    SetQuillContent(QuillArray);

    for (let i = 0; i < JSON.parse($recipeObject.tags).length; i++) {
        const id = JSON.parse($recipeObject.tags)[i];
        AddTag(id);
    }


    var ingredients = JSON.parse($recipeObject.ingredients);
    for (let i = 0; i < ingredients.length; i++) {
        const element = ingredients[i];        
        AddRow(i, $('#recipe_ingredients')[0], element.amount+" "+element.amountType+" "+element.name);
    }

    var instructions = JSON.parse($recipeObject.instructions);
    for (let i = 0; i < instructions.length; i++) {
        const element = instructions[i];
        AddRow(i, $('#recipe_instructions')[0], element.amountType);
    }
}

function AddRow(id, $div, dataString) {
    var element = document.createElement("div");
    element.appendChild(document.createElement("input"));
    element.appendChild(document.createElement("span"));
    element.children[0].setAttribute("type","checkbox");
    element.children[0].name = "Instruction_"+id;
    element.children[0].id = "Instruction_"+id;
    element.children[1].innerText = " - "+dataString;

    $div.appendChild(element);
}

function AddTag(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var temp = JSON.parse(this.response);
            if (temp.returnCode == 's190')
            {
                var tagObject = document.createElement("div");
                tagObject.appendChild(document.createElement("a"));
                tagObject.children[0].href = "#";
                tagObject.children[0].innerText = temp.tag;

                $('#recipe_tags')[0].appendChild(tagObject);
            }
        }
    };
    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=GetTagName&id="+id);
}