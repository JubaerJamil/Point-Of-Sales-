<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Update Product Details</h6>
                </div>
                <div class="modal-body">
                    <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Category*</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Name *</label>
                                <input type="text" class="form-control" id="productNameUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Price *</label>
                                <input type="text" class="form-control" id="productpriceUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Unit *</label>
                                <input type="text" class="form-control" id="productunitUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Image *</label>
                                <img class="rounded float-left d-block w-30" alt="..." id="oldImg" src="{{ asset('img/uploaders2.png') }}">
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" id="productimgUpdate" class="mt-3 border border-muted form-control" type="file">

                                <input type="text" class="d-none", id="updateId">
                                <input type="text" class="d-none", id="file_path">
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Saveupdate()" id="update-btn" class="btn btn-sm btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>

<script>

async function categoryfillupforUpdate(){
        let res = await axios.get('/category-list');
        res.data.forEach(function(item,i){
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $('#productCategoryUpdate').append(option);
        })
    }


async function fillupdateForm(id,file_path){

    document.getElementById('updateId').value=id;
    document.getElementById('file_path').value=file_path;


    document.getElementById('loading-div').classList.remove('d-none');
    document.getElementById('content-div').classList.add('d-none');

        await categoryfillupforUpdate();

        let res = await axios.post('/product-by-id', {id:id});

    document.getElementById('loading-div').classList.add('d-none');
    document.getElementById('content-div').classList.remove('d-none');

    document.getElementById('productCategoryUpdate').value= res.data['category_id'];
    document.getElementById('productNameUpdate').value= res.data['name'];
    document.getElementById('productpriceUpdate').value= res.data['price'];
    document.getElementById('productunitUpdate').value= res.data['unit'];
    document.getElementById('oldImg').src=file_path;

}


async function Saveupdate(){

    let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
    let productNameUpdate = document.getElementById('productNameUpdate').value;
    let productpriceUpdate = document.getElementById('productpriceUpdate').value;
    let productunitUpdate = document.getElementById('productunitUpdate').value;
    let updateId = document.getElementById('updateId').value;
    let file_path = document.getElementById('file_path').value;
    let productimgUpdate = document.getElementById('productimgUpdate').files[0];


    if (productCategoryUpdate === 0) {
        alert('Product Category Required !');
    }
    else if (productNameUpdate === 0) {
        alert('Product Name Required !');
    }
    else if (productpriceUpdate === 0) {
        alert('Product Price Required !');
    }
    else if (productunitUpdate === 0) {
        alert('Product Unit Required !');
    }
    else {
        document.getElementById('update-modal-close').click();

        let formData = new FormData();

        formData.append('category_id', productCategoryUpdate)
        formData.append('name', productNameUpdate)
        formData.append('price', productpriceUpdate)
        formData.append('unit', productunitUpdate)
        formData.append('id', updateId)
        formData.append('file_path', file_path)
        formData.append('img_url', productimgUpdate)

        const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

    document.getElementById('loading-div').classList.remove('d-none');
    document.getElementById('content-div').classList.add('d-none');

        let res = await axios.post('/product-update',formData,config);

    document.getElementById('loading-div').classList.add('d-none');
    document.getElementById('content-div').classList.remove('d-none');

    if(res.status===200 && res.data===1){
                alert('Updated successfully');
                document.getElementById("update-form").reset();
                await getList();
            }
            else{
                alert("Request fail !")
            }
    }
}

</script>
