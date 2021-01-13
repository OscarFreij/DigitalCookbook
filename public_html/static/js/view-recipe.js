var EditorArray = Array();

document.addEventListener("DOMContentLoaded", function()
{
    //ViewQuill();
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
    PutContent();
}

function PutContent() {
    var searchString = "id=";
    var searchString2 = "&edit=";
    var url = window.location.href;
    var startPos = url.indexOf(searchString)+searchString.length;
    var startPos2 = url.indexOf(searchString2);
    var lenght = startPos2-startPos;
    var id = url.substr(startPos,lenght);
}