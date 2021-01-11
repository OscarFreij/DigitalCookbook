// GLOBAL VARIABEL START //

var editingMode = false;

// GLOBAL VARIABEL END //


// FUNCTION TRIGGERS START //

document.addEventListener("DOMContentLoaded", function() {
    reorderCategories();

    try {
        var $categories = $('#category_wrapper').find('.category');    
        var searchString = "?category=";
        var url = window.location.href;
        var startPos = url.indexOf(searchString)+searchString.length;
        var id = url.substr(startPos);

        for (let i = 0; i < $categories.length; i++) {
            const element = $categories[i];
            
            if (element.dataset.categoryid == id)
            {
                element.classList.add("active");
                break;
            }
        }

    } catch (error) {
        
    }
    
});

// FUNCTION TRIGGERS END //


// CATEGORY SORTING START //

function moveCategoryUp(id)
{
    if (id >= 0)
    {
        element1 = document.querySelector("#category_"+id);
        element2 = document.querySelector("#category_"+(id-1));

        if (element2 != null)
        {
            element1.dataset.order = parseInt(element1.dataset.order) - 1;
            element2.dataset.order = parseInt(element2.dataset.order) + 1;
    
            element1.id = "category_"+element1.dataset.order;
            element2.id = "category_"+element2.dataset.order;
    
            element1.querySelector(".EditPanel").children[0].setAttribute( "onClick", "moveCategoryUp("+element1.dataset.order+")");
            element2.querySelector(".EditPanel").children[0].setAttribute( "onClick", "moveCategoryUp("+element2.dataset.order+")");
            element1.querySelector(".EditPanel").children[1].setAttribute( "onClick", "moveCategoryDown("+element1.dataset.order+")");
            element2.querySelector(".EditPanel").children[1].setAttribute( "onClick", "moveCategoryDown("+element2.dataset.order+")");
        }
        reorderCategories();
    }
}

function moveCategoryDown(id)
{
    if (id >= 0)
    {
        element1 = document.querySelector("#category_"+id);
        element2 = document.querySelector("#category_"+(id+1));

        if (element2 != null)
        {
            element1.dataset.order = parseInt(element1.dataset.order) + 1;
            element2.dataset.order = parseInt(element2.dataset.order) - 1;
    
            element1.id = "category_"+element1.dataset.order;
            element2.id = "category_"+element2.dataset.order;
    
            element1.querySelector(".EditPanel").children[0].setAttribute( "onClick", "moveCategoryUp("+element1.dataset.order+")");
            element2.querySelector(".EditPanel").children[0].setAttribute( "onClick", "moveCategoryUp("+element2.dataset.order+")");
            element1.querySelector(".EditPanel").children[1].setAttribute( "onClick", "moveCategoryDown("+element1.dataset.order+")");
            element2.querySelector(".EditPanel").children[1].setAttribute( "onClick", "moveCategoryDown("+element2.dataset.order+")");
        }
        reorderCategories();
    }
}

function reorderCategories()
{
    var $wrapper = $('#category_wrapper');

    $wrapper.find('.category').sort(function (a, b) {
        return +a.dataset.order - +b.dataset.order;
    })
    .appendTo( $wrapper );

    for (let i = 0; i < $wrapper.find('.category').length; i++) {
        const element = $wrapper.find('.category')[i];
        element.dataset.order = i;
    }
}

// CATEGORY SORTING END //


// BTN PANEL START //

function addEditBtn(row)
{
    element1 = document.createElement("div");
    element1.classList.add("EditPanel");
    element1.classList.add("btn-group");

    btn1 = document.createElement("button");
    btn2 = document.createElement("button");
    btn3 = document.createElement("button");

    btn1.setAttribute( "onClick", "moveCategoryUp("+row.dataset.order+")");
    var img1 = new Image();
    img1.src = "static/media/arrow-up-short.svg";
    btn1.appendChild(img1);
    btn1.classList.add("btn");
    btn1.classList.add("btn-primary");

    btn2.setAttribute( "onClick", "moveCategoryDown("+row.dataset.order+")");
    var img2 = new Image();
    img2.src = "static/media/arrow-down-short.svg";
    btn2.appendChild(img2);
    btn2.classList.add("btn");
    btn2.classList.add("btn-primary");

    btn3.setAttribute( "onClick", "removalModalUpdate("+row.dataset.categoryid+")");
    var img3 = new Image();
    img3.src = "static/media/trash.svg";
    btn3.appendChild(img3);
    btn3.classList.add("btn");
    btn3.classList.add("btn-danger");
    btn3.setAttribute("data-bs-toggle", "modal");
    btn3.setAttribute("data-bs-target", "#removalModal");

    element1.appendChild(btn1);
    element1.appendChild(btn2);
    element1.appendChild(btn3);

    row.appendChild(element1);
}

function removalModalUpdate(id)
{
    $('#removalModal').find('.modal-footer')[0].children[0].setAttribute("onClick", "removeCategory("+id+")");
}

function removeEditBtn(row)
{
    row.getElementsByClassName("EditPanel")[0].remove();
}

function ToggleEdit()
{
    var $categories = $('#category_wrapper').find('.category');

    if (!editingMode)
    {
        for (let i = 0; i < $categories.length; i++) {
            const element = $categories[i];
            addEditBtn(element);
        }
        editingMode = true;    
        $('#ToggleEditBtn')[0].innerText = "Save";
        $('#ToggleEditBtn')[0].setAttribute("class", "btn btn-success");
    }
    else
    {
        for (let i = 0; i < $categories.length; i++) {
            const element = $categories[i];
            removeEditBtn(element);
        }
        editingMode = false;    
        $('#ToggleEditBtn')[0].innerText = "Edit";
        $('#ToggleEditBtn')[0].setAttribute("class", "btn btn-warning");
        updateCategories();
    }

    
    
}

// BTN PANEL END //

// DBConn START //

function addCategory()
{
    var $categories = $('#category_wrapper').find('.category');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
       }
    };

    var nextId = 1;

    if ($categories.length > 0)
    {
        nextId = parseInt($categories[$categories.length-1].dataset.order)+1;   
    }

    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=AddCategory&name="+$('#ACMNameInput')[0].value+"&nextId="+nextId);
    $('#ACMNameInput')[0].value = "";
    
    location.reload();
}

function removeCategory(id)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
       }
    };
    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=RemoveCategory&id="+id);
    
    for (let i = 0; i < $('.category').length; i++) {
        const element = $('.category')[i];
        if (id == element.dataset.categoryid)
        {
            element.remove();
            break;
        }
    }

    reorderCategories();
    updateCategories()
}

function updateCategories() {
    
    var JSON_Categories = new Array();
    var $categories = $('#category_wrapper').find('.category');

    for (let i = 0; i < $categories.length; i++) {
        const element = $categories[i];
        JSON_Categories.push(new Array(element.dataset.categoryid, element.dataset.order));
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
       }
    };
    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=UpdateCategories&JSON_Categories="+JSON.stringify(JSON_Categories));
    
    location.reload();
}

// DBConn END //
