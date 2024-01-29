<div class="container-fluid mt-5">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between">
                <div class="align-items-center col">
                    <h6 class="fs-3">Product List</h6>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-secondary"/>
            <div class="table-responsive">
            <table class="table  table-flush" id="tableData">
                <thead>
                <tr class="bg-info">
                    <th>No</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>


<script>

        getList();
async function getList(){

    // loader show, content hide
    document.getElementById('loading-div').classList.remove('d-none');
    document.getElementById('content-div').classList.add('d-none');

        let res = await axios.get("/product-list");

    // loader hide, content show
    document.getElementById('loading-div').classList.add('d-none');
    document.getElementById('content-div').classList.remove('d-none');

    let tableList = $('#tableList');
    let tableData = $('#tableData');

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.forEach(function (item,index){
        let row = `
                <tr>
                    <td>${index +1}</td>
                    <td>${item['name']}</td>
                    <td>${item['price']}</td>
                    <td>${item['unit']}</td>
                    <td><img class="rounded w-40 h-auto" alt="..."  src="${item['img_url']}"></td>
                    <td>
                        <button data-path ="${item['img_url']}" data-id ="${item['id']}" class= "Editbtn btn btn-outline-success text-sm px-3 py-1  m-0">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button data-path ="${item['img_url']}" data-id ="${item['id']}" class= "Deletebtn btn btn-outline-danger text-sm px-3 py-1 m-0">
                            <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </td>
                </tr>`

        tableList.append(row)
    })

    $('.Editbtn').on('click', async function(){
        let id = $(this).data('id');
        let file_path = $(this).data('path');
        await fillupdateForm(id,file_path);
        $('#update-modal').modal('show');
    });

    $('.Deletebtn').on('click', function(){
        let id = $(this).data('id');
        let filepath = $(this).data('path');
        $('#delete-modal').modal('show');
        $('#deleteID').val(id);
        $('#deleteImg').val(filepath);
    });


    tableData.DataTable({
        order:[[0,'dsc']],
        lengthMenu:[10, 25, 50, 100, 250, 500]
    });

}


</script>
