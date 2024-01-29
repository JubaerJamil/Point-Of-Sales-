<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create New Customer</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Phone Number *</label>
                                <input type="text" class="form-control" id="customerPhone">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email Address</label>
                                <input type="email" class="form-control" id="customerMail">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function Save() {
        let customerName = document.getElementById('customerName').value;
        let customerPhone = document.getElementById('customerPhone').value;
        let customerMail = document.getElementById('customerMail').value;

        if (customerName.length === 0) {
            alert('Fill Up All Fields');
        }
        else if(customerPhone.length===0){
            alert('Fill Up All Fields');
        }
        else if(customerMail.length===0){
            alert('Fill Up All Fields');
        }
        else {
            document.getElementById('modal-close').click();
             // loader show, content hide
        document.getElementById('loading-div').classList.remove('d-none');
        document.getElementById('content-div').classList.add('d-none');
            let res = await axios.post("/create-customer",{
                name:customerName,
                phone_number:customerPhone,
                email:customerMail
            })
        // loader hide, content show
        document.getElementById('loading-div').classList.add('d-none');
        document.getElementById('content-div').classList.remove('d-none');
            if(res.status===201 ){
                alert('Added successfully');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                alert('Request failed');
            }
        }
    }

</script>
