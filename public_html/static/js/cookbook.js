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
    
            element1.children[0].setAttribute( "onClick", "moveCategoryUp("+element1.dataset.order+")");
            element2.children[0].setAttribute( "onClick", "moveCategoryUp("+element2.dataset.order+")");
            element1.children[1].setAttribute( "onClick", "moveCategoryDown("+element1.dataset.order+")");
            element2.children[1].setAttribute( "onClick", "moveCategoryDown("+element2.dataset.order+")");
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
    
            element1.children[0].setAttribute( "onClick", "moveCategoryUp("+element1.dataset.order+")");
            element2.children[0].setAttribute( "onClick", "moveCategoryUp("+element2.dataset.order+")");
            element1.children[1].setAttribute( "onClick", "moveCategoryDown("+element1.dataset.order+")");
            element2.children[1].setAttribute( "onClick", "moveCategoryDown("+element2.dataset.order+")");
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
}