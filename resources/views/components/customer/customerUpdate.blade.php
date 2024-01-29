<div class="modal" tabindex="-1" id="update-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title fs-1 text-danger">Update!</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <p class="fs-3 text-center text-primary">Do you want to update this name?</p>
          {{-- <input style="margin-left: 100px; padding-right: 100px;" class="text-start" id="updateforID"> --}}
          <input style="margin-left: 100px; padding-right: 100px;" class="d-none" id="updateID">
          <div class="col-12 p-1">
            <label class="form-label">Customer Name *</label>
            <input type="text" class="form-control" id="updateName">
        </div>
        <div class="col-12 p-1">
            <label class="form-label">Customer Phone Number *</label>
            <input type="text" class="form-control" id="updatePhone">
        </div>
        <div class="col-12 p-1">
            <label class="form-label">Customer Email Address</label>
            <input type="email" class="form-control" id="updateEmail">
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="modalClose">Cancel</button>
          <button onclick="updateCustomer()" type="button" class="btn btn-sm btn-primary" id="updateIt">Update</button>
        </div>
      </div>
    </div>
  </div>


<script>

    async function fillupcategory(id) {
        document.getElementById('updateID').value = id;

        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');

            let res = await axios.post("/customer-by-id",{id:id});

        document.getElementById('loading-div').classList.add('d-none');
        document.getElementById('content-div').classList.remove('d-none');

        document.getElementById('updateName').value = res.data['name'];
        document.getElementById('updatePhone').value = res.data['phone_number'];
        document.getElementById('updateEmail').value = res.data['email'];
    }


    async function updateCustomer() {
        let updateName = document.getElementById('updateName').value;
        let updatePhone = document.getElementById('updatePhone').value;
        let updateEmail = document.getElementById('updateEmail').value;
        let customerid = document.getElementById('updateID').value;

        if (updateName.length === 0) {
            alert('Please fill-up all fields');
        }
        else if(updatePhone.length===0){
            alert('Please fill-up all fields');
        }
        else if(updateEmail.length===0){
            alert('Please fill-up all fields');
        }
        else {
        document.getElementById('modalClose').click();

        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');

            let res = await axios.post("/customer-update",{name:updateName, phone_number:updatePhone, email:updateEmail, id:customerid});

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
