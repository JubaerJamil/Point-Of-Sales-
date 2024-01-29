<div class="container-fluid mt-5">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between">
                <div class="align-items-center col">
                    <h6 class="fs-3">Customer List</h6>
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
                    <th>Phone Number</th>
                    <th>Email Address</th>
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

        let res = await axios.get("/customer-list");

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
                    <td>${item['phone_number']}</td>
                    <td>${item['email']}</td>
                    <td>
                        <button data-id ="${item['id']}" class= "Editbtn btn btn-outline-success text-sm px-3 py-1  m-0">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button data-id ="${item['id']}" class= "Deletebtn btn btn-outline-danger text-sm px-3 py-1 m-0">
                            <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </td>
                </tr>`

        tableList.append(row)
    })

    $('.Editbtn').on('click', async function(){
        let id = $(this).data('id');
        await fillupcategory(id);
        $('#update-modal').modal('show');
    });

    $('.Deletebtn').on('click',function () {
        let id= $(this).data('id');
        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
    });


    // tableData.DataTable({
    //     order:[[0,'dsc']],
    //     lengthMenu:[10, 25, 50, 100, 250, 500]
    // });


    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[10,25,50,100,500]
    });



}


</script>
