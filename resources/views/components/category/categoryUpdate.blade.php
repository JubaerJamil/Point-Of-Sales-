<div class="modal" tabindex="-1" id="update-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title fs-1 text-danger">Update!</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <p class="fs-3 text-center text-primary">Do you want to update this name?</p>
          <input style="margin-left: 100px; padding-right: 100px;" class="text-start" id="updateforID">
          <input style="margin-left: 100px; padding-right: 100px;" class=" d-none" id="updateID">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="modalClose">Cancel</button>
          <button onclick="updateCategory()" type="button" class="btn btn-sm btn-primary" id="updateIt">Update</button>
        </div>
      </div>
    </div>
  </div>


<script>

    async function fillupcategory(id) {
        document.getElementById('updateID').value = id;
        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');
            let res = await axios.post("/category-By-Id",{id:id});
        document.getElementById('loading-div').classList.add('d-none');
        document.getElementById('content-div').classList.remove('d-none');
        document.getElementById('updateforID').value = res.data['name'];
    }


    async function updateCategory() {
        let categoryname = document.getElementById('updateforID').value;
        let categoryid = document.getElementById('updateID').value;
        if (categoryname.length === 0) {
            alert('Please input a category');
        }
        else {
        document.getElementById('modalClose').click();
        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');
            let res = await axios.post("/category-update",{name:categoryname, id:categoryid});
        document.getElementById('loading-div').classList.add('d-none');
        document.getElementById('content-div').classList.remove('d-none');
        if (res.status === 200 && res.data === 1){
            alert('Updated successfully');
            await getList();
        }
        else{
            alert('update failed');
        }
        }
    }
</script>
