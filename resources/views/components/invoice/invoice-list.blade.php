<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h5>All Invoices List</h5>
                </div>
                <div class="align-items-center col">
                    <a    href="{{url("/invoice-page")}}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Vat</th>
                    <th>Discount</th>
                    <th>Payable</th>
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

<script>
            getinvoicelist();
    async function getinvoicelist() {

    document.getElementById('loading-div').classList.remove('d-none');
    document.getElementById('content-div').classList.add('d-none');

        let res = await axios.get("/invoice-select");

    // loader hide, content show
    document.getElementById('loading-div').classList.add('d-none');
    document.getElementById('content-div').classList.remove('d-none');

    let tableData = $('#tableData');
    let tableList = $('#tableList');

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.forEach(function (item, index) {
        let row =
            `<tr>
                <td>${index+1}</td>
                <td>${item['customer']['name']}</td>
                <td>${item['customer']['phone_number']}</td>
                <td>${item['total']}</td>
                <td>${item['vat']}</td>
                <td>${item['discount']}</td>
                <td>${item['payable']}</td>
                <td>
                    <button data-id=${item['id']}, data-cus=${item['customer']['id']}
                    class="viewBtn btn btn-outline-success text-sm px-3 py-1  m-0"><i class="fa fa-eye" aria-hidden="true"></i></button>

                    <button data-id=${item['id']}, data-cus=${item['customer']['id']}
                    class="deleteBtn btn btn-outline-danger text-sm px-3 py-1 m-0"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr>`
        tableList.append(row)
    })

    $('.viewBtn').on('click', async function(){
        let id = $(this).data('id');
        let cus = $(this).data('cus');
        await invoiceDetails(cus,id)
    });

    $('.deleteBtn').on('click', function(){
        let id = $(this).data('id');
        document.getElementById('deleteID').value=id;
        $('#invoice-delete-modal').modal('show');
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[10,25,50,100,500]
    });

}

</script>
