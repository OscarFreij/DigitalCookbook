<!-- removalModal -->
<div class="modal fade" id="removalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel_1">Are you sure?</h5>
        </div>
        <div class="modal-body">
            Are you sure you want to remove category with name: <p>CATEGORY_NAME</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Confirm</button>    
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>                
        </div>
        </div>
    </div>
</div>

<!-- AddCategoryModal -->
<div class="modal fade" id="AddCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel_2">Create new category</h5>
        </div>
        <div class="modal-body">
            Enter category name:
            <input type="text" class="form-control" id="ACMNameInput">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="addCategory()">Create</button>    
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>                
        </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>