<!-- removalModal -->
<div class="modal fade" id="removalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel_1">Är du säker?</h5>
        </div>
        <div class="modal-body">
            Är du säker att du vill ta bort kategorin med namnet: <span id="removalModalCName">CATEGORY_NAME</span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ja</button>    
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Avbryt</button>                
        </div>
        </div>
    </div>
</div>

<!-- AddCategoryModal -->
<div class="modal fade" id="AddCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel_2">Skapa ny kategori</h5>
        </div>
        <div class="modal-body">
            Skriv in kategorin namn:
            <input type="text" class="form-control" id="ACMNameInput">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="addCategory()">Skapa</button>    
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Avbryt</button>                
        </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>