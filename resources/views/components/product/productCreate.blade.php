<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create A New Product</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Category*</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Name *</label>
                                <input type="text" class="form-control" id="productName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Price *</label>
                                <input type="text" class="form-control" id="productPrice">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Unit *</label>
                                <input type="text" class="form-control" id="productUnit">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label font-weight-bold">Product Image *</label>
                                <img class="rounded float-left d-block w-30" alt="..." id="newImg" src="{{ asset('img/uploaders2.png') }}">
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" id="productimg" class="mt-3 border border-muted form-control" type="file">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn btn-sm btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

        categoryfillup();

    async function categoryfillup(){
        let res = await axios.get('/category-list');
        res.data.forEach(function(item,i){
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $('#productCategory').append(option);
        })
    }

    async function Save(){

        let productCategory = document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productimg = document.getElementById('productimg').files[0];


        if (productCategory.length === 0) {
            console.log(productCategory);
        }
        else if (productName.length === 0) {
            alert('Please enter a product name');
        }
        else if (productPrice.length === 0) {
            alert('Please enter a product price');
        }
        else if (productUnit.length === 0) {
            alert('Please enter product unit');
        }
        else if (!productimg) {
            alert('Please select an image');
        }

        else {

            document.getElementById('modal-close').click();

            let formData = new FormData();
            formData.append('category_id', productCategory)
            formData.append('name', productName)
            formData.append('price', productPrice)
            formData.append('unit', productUnit)
            formData.append('img_url', productimg)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            document.getElementById('loading-div').classList.remove('d-none');
            document.getElementById('content-div').classList.add('d-none');

                let res = await axios.post('/create-product',formData,config);

            document.getElementById('loading-div').classList.add('d-none');
            document.getElementById('content-div').classList.remove('d-none');

            if(res.status === 201){
                alert ('Product information successfully updated')
                document.getElementById('save-form').reset();
                await getList();
            }
            else {
                alert('Request failed! Something went wrong')
            }
        }
    }

</script>
