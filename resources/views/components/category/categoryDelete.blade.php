<div class="modal" tabindex="-1" id="delete-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title fs-1 text-danger">Delete!</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <p class="fs-3 text-center text-primary">Are You Sure! Want To Delete It?</p>
          <input class="text-center d-none" id="deleteID">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalclose">Cancel</button>
          <button onclick="deleteItem()" type="button" class="btn btn-primary" id="deleteIt">Delete</button>
        </div>
      </div>
    </div>
  </div>


<script>
    async function deleteItem(){
        let id = document.getElementById('deleteID').value;
                document.getElementById('modalclose').click();
        // loader show, content hide
        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');
            let res = await axios.post("/category-delete",{id:id});
        // loader hide, content show
        document.getElementById('loading-div').classList.add('d-none');
        document.getElementById('content-div').classList.remove('d-none');
        if(res.data === 1)
        {
            alert('Delete Successfully Done');
            await getList();
        }
        else
        {
            alert('Request Failed');
        }
    }
</script>
