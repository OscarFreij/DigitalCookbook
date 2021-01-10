var editingMode = false;


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

function addEditBtn(row)
{
    element1 = document.createElement("div");
    element1.classList.add("EditPanel");
    element1.classList.add("btn-group");

    btn1 = document.createElement("button");
    btn2 = document.createElement("button");

    btn1.setAttribute( "onClick", "moveCategoryUp("+row.dataset.order+")");
    btn1.appendChild(document.createTextNode("UP"));
    btn1.classList.add("btn");
    btn1.classList.add("btn-primary");

    btn2.setAttribute( "onClick", "moveCategoryDown("+row.dataset.order+")");
    btn2.appendChild(document.createTextNode("DOWN"));
    btn2.classList.add("btn");
    btn2.classList.add("btn-primary");

    element1.appendChild(btn1);
    element1.appendChild(btn2);

    row.appendChild(element1);
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
    }
    else
    {
        for (let i = 0; i < $categories.length; i++) {
            const element = $categories[i];
            removeEditBtn(element);
        }
        editingMode = false;    
    }
    
}


function reorderCategories()
{
    var $wrapper = $('#category_wrapper');

    $wrapper.find('.category').sort(function (a, b) {
        return +a.dataset.order - +b.dataset.order;
    })
    .appendTo( $wrapper );
}