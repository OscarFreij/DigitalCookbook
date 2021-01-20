var responsDATA;
var offset = 0;
var rowCount = 5;

document.addEventListener("DOMContentLoaded", function()
{
    LoadMoreRows(0,10);
});


function LoadMoreRows(local_offset = offset, local_rowCount = rowCount) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            responsDATA = JSON.parse(this.response);

            if (responsDATA.returnCode == 's230')
            {
                responsDATA.rows.forEach(element => {
                    $('#wrapper-rows')[0].appendChild($.parseHTML(element)[0]);
                });
                offset += responsDATA.rows.length;
            }
        }
    };
    xhttp.open("POST", "callback.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=GetRecipesInInterval&offset="+local_offset+"&rowCount="+local_rowCount);
}