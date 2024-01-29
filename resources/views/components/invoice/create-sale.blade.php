<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <div class="row">
                    <div class="col-8">
                        <span class="text-bold text-dark">BILLED TO </span>
                        <p class="text-xs mx-0 my-1 ">Name:  <span id="CName"></span> </p>
                        <p class="text-xs mx-0 my-1 ">Phone:  <span id="PNumber"></span> </p>
                        <p class="text-xs mx-0 my-1 ">Email:  <span id="CEmail"></span></p>
                        <p class="text-xs mx-0 my-1 ">User ID:  <span id="CId"></span> </p>
                    </div>
                    <div class="col-4">
                        <img class="w-50" src="{{ asset('img/favicon.png') }}">
                        {{-- <p class="text-bold mx-0 my-1 text-dark fs-5">Invoice</p> --}}
                        <p class="text-xs mx-0 my-1 fs-6 text-bold">{{ date('d-m-Y h:i A') }}</p>
                    </div>
                </div>

                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                    <div class="col-12">
                        <table class="table w-100" id="invoiceTable">
                            <thead class="w-100">
                            <tr class="text-xs">
                                <td>Name</td>
                                <td>Unit Price</td>
                                <td>Qty</td>
                                <td>Total</td>
                                <td>Remove product</td>
                            </tr>
                            </thead>
                            <tbody  class="w-100" id="invoiceList">

                            </tbody>
                        </table>
                    </div>
                </div>


                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                <div class="col-12">
                    <p class="text-bold text-m my-1 text-dark">Sub Total: Tk. <span id="subtotal"></span></p>

                    <p class="text-bold text-xs my-1 text-dark"> Total: Tk. <span id="total"></span></p>

                    <p class="text-bold text-xs my-1 text-dark"> VAT(5%): Tk. <span id="vat"></span></p>

                    <p class="text-bold text-xs my-1 text-dark"> Discount: Tk. <span id="discount"></span></p>

                    <span class="text-xxs">Discount(%):</span>
                    <input onkeydown="return" type="number" value="0" onchange="DiscountChange()"class="form-control w-40 " id="discountP"/>

                    <p class="text-bold text-s my-2 text-dark"> FINAL PAYABLE: Tk. <span id="payable"></span></p>

                    <p>
                        <button onclick="CreateInvoice()" class="btn  my-3 bg-gradient-primary w-40">Confirm</button>
                    </p>

                </div>
                    <div class="col-12 p-2">

                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-4 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <table class="table  w-100" id="productTable">
                    <thead class="w-100">
                    <tr class="text-xs text-bold">
                        <td>Product</td>
                        <td>Pick</td>
                    </tr>
                    </thead>
                    <tbody  class="w-100" id="productList">

                    </tbody>
                </table>
            </div>
        </div>


        <div class="col-md-4 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <table class="table table-sm w-100" id="customerTable">
                    <thead class="w-100">
                    <tr class="text-xs text-bold">
                        <td>Customer</td>
                        <td>Pick</td>
                    </tr>
                    </thead>
                    <tbody  class="w-100" id="customerList">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

                    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 p-1">
                                                    <label class="form-label">Product Id *</label>
                                                    <input readonly type="text" class="form-control" id="PId">
                                                    <label class="form-label mt-2">Product Name *</label>
                                                    <input readonly type="text" class="form-control" id="PName">
                                                    <label class="form-label mt-2">Product Price *</label>
                                                    <input readonly type="text" class="form-control" id="PPrice">
                                                    <label class="form-label mt-2">Product Qty *</label>
                                                    <input type="text" class="form-control" id="PQty">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button onclick="addproducttoinvoice()" id="save-btn" class="btn bg-gradient-success" >Add</button>
                                </div>
                            </div>
                        </div>
                    </div>




<script>

            (async ()=>{
                document.getElementById('loading-div').classList.remove('d-none');
                document.getElementById('content-div').classList.add('d-none');
                    await allcustomerlist();
                    await allproductlist();
                document.getElementById('loading-div').classList.add('d-none');
                document.getElementById('content-div').classList.remove('d-none');
                    })()


        let InvoiceItemList=[];

        function ShowInvoiceItem() {
            let invoiceList = $('#invoiceList');
            invoiceList.empty();

            InvoiceItemList.forEach( function (item,index){
                let row = `<tr class="text-xs">
                                <td>${item['product_name']}</td>
                                <td>${item['product_price']}</td>
                                <td>${item['quantity']}</td>
                                <td>${item['sale_price']}</td>
                                <td><a data-index="${index}" class="btn btn-outline-danger btn-sm remove text-xxs my-0 rounded-pill" style="width:55px">Remove</a></td>
                            </tr>`;
                invoiceList.append(row);
            });

                CalculateGrandTotal();

                $('.remove').on('click', async function() {
                let index = $(this).data('index');
                    removeItem(index);
                });
        }

        function removeItem(index) {
                InvoiceItemList.splice(index, 1);
                ShowInvoiceItem();
            }


        function DiscountChange(){
                CalculateGrandTotal();
            }


        function CalculateGrandTotal() {
                let SubTotal = 0;
                let Total = 0;
                let Vat = 0;
                let Discount = 0;
                let Payable = 0;
                let DiscountPercentage = parseFloat(document.getElementById('discountP').value);

                InvoiceItemList.forEach ((item, index) => {
                    Total = Total + parseFloat(item['sale_price']);
                });

                SubTotal = Total;

                if (DiscountPercentage === 0) {
                    Vat = ((Total * 5) / 100).toFixed(2);
                } else {
                    Discount = ((Total * DiscountPercentage) / 100).toFixed(2);
                    Total = (Total - ((Total * DiscountPercentage) / 100)).toFixed(2);
                    Vat = ((Total * 5) / 100).toFixed(2);
                }

                Payable = (parseFloat(Total) + parseFloat(Vat)).toFixed(2);

                    document.getElementById("subtotal").innerHTML = SubTotal;
                    document.getElementById("total").innerHTML = Total;
                    document.getElementById("vat").innerHTML = Vat;
                    document.getElementById("discount").innerHTML = Discount;
                    document.getElementById("payable").innerHTML = Payable;
            }

        function addproducttoinvoice() {
            let PId = document.getElementById('PId').value;
            let PName = document.getElementById('PName').value;
            let PPrice = document.getElementById('PPrice').value;
            let PQty = document.getElementById('PQty').value;
            let TotalPrice = (parseFloat(PPrice) * parseFloat(PQty)).toFixed(2);

            if (PId.length === 0){
                alert('Product ID required');
            }
            else if(PName.length === 0) {
                alert('Product Name required');
            }
            else if(PPrice.length === 0) {
                alert('Product Price required');
            }
            else if(PQty.length === 0) {
                alert('Product Qty required');
            }
            else {
                let item = {product_name:PName, product_price:PPrice, product_id:PId, quantity:PQty, sale_price:TotalPrice};
                InvoiceItemList.push(item);
                console.log(InvoiceItemList);
                $('#create-modal').modal('hide');
                ShowInvoiceItem();

            }
        }



    async function allproductlist() {

        let res = await axios.get('/product-list');
        let productTable = $('#productTable');
        let productList = $('#productList');
        productTable.DataTable().destroy();
        productList.empty();

        res.data.forEach( function (item, index) {
                let row = `<tr class="text-xs">
                                <td> <img class="w-10" src="${item['img_url']}"> ${item['name']} ($ ${item['price']}) </td>
                                <td> <a class="btn btn-outline-dark text-xxs px-2 py-1 btn-sm m-0 addProduct" data-name="${item['name']}"
                                data-price="${item['price']}" data-id="${item['id']}">ADD</a></td>
                        </tr>`;
                productList.append(row);
        });

        $('.addProduct').on('click', async function (){
            let PName = $(this).data('name');
            let PPrice = $(this).data('price');
            let PId = $(this).data('id');
            addmodal(PId,PName,PPrice)
        })

        new DataTable('#productTable', {
                order: [[0, 'desc']],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
    }

        function addmodal(id,name,price){
            $('#create-modal').modal('show')
            document.getElementById('PId').value=id
            document.getElementById('PName').value=name
            document.getElementById('PPrice').value=price

        }


        allcustomerlist();
    async function allcustomerlist() {

            let res = await axios.get("/customer-list");
            let customerTable = $('#customerTable');
            let customerList = $('#customerList');
            customerTable.DataTable().destroy();
            customerList.empty();

            res.data.forEach(function (item, index) {
                let row = `<tr class="text-xs">
                                <td><i class="bi bi-person"></i> ${item['name']}</td>
                                <td>
                                    <a data-name="${item['name']}" data-email="${item['email']}" data-id="${item['id']}"
                                    data-phone_number="${item['phone_number']}" class="btn btn-outline-dark addCustomer text-xxs px-2 py-1  btn-sm m-0">Add</a>
                                </td>
                            </tr>`;
                customerList.append(row);
            });

            $('.addCustomer').on('click', function () {
                let CName = $(this).data('name');
                let PNumber = $(this).data('phone_number');
                let CEmail = $(this).data('email');
                let CId = $(this).data('id');

                $("#CName").text(CName);
                $("#PNumber").text(PNumber);
                $("#CEmail").text(CEmail);
                $("#CId").text(CId);
            });

            new DataTable('#customerTable', {
                order: [[0, 'desc']],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
    }


    async  function CreateInvoice() {
            let Total=document.getElementById('total').innerText;
            let Discount=document.getElementById('discount').innerText;
            let Vat=document.getElementById('vat').innerText;
            let Payable=document.getElementById('payable').innerText;
            let CId=document.getElementById('CId').innerText;


            let Data={
                "total":Total,
                "discount":Discount,
                "vat":Vat,
                "payable":Payable,
                "customer_id":CId,
                "products":InvoiceItemList
            }


            if(CId.length===0){
                alert("Customer Required !");
            }
            else if(InvoiceItemList.length===0){
                alert("Product Required !")
            }
            else{

                    // loader show, content hide
                document.getElementById('loading-div').classList.remove('d-none');
                document.getElementById('content-div').classList.add('d-none');

                        let res=await axios.post("/invoice-create",Data)

                    // loader hide, content show
                document.getElementById('loading-div').classList.add('d-none');
                document.getElementById('content-div').classList.remove('d-none');

                if(res.data===1){

                    window.location.href='/invoice-list'
                    // alert("Invoice Created");
                }
                else{
                    invoice-create("Something Went Wrong")
                }
            }

        }


    </script>
