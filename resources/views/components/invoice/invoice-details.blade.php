<!-- Modal -->
<div class="modal animated zoomIn" id="invdetails-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">

        <div class="modal-content">
            <div id="invoice" class="col-sm-12">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3 pt-0">
                    <div class="row">
                        <div class="justify-content-center mx-0">
                            <h3 class="text-bold text-center mt-3" id="userName"></h3>
                            <p class="text-center text-xs" id="address"><span class="text-bold text-m" id="address2">Address::</span></p>
                            <p class="text-center text-bold pt-0">Bill/Invoice Copy</p>
                            <hr class="mx-0 my-0 p-0 bg-secondary"/>
                        </div>
                        <div class="col-8">
                            <span class="text-bold text-dark mt-0">BILLED TO </span>
                            <p class="text-xs mx-0 my-1 ">Name:  <span id="CName"></span> </p>
                            <p class="text-xs mx-0 my-1 ">Phone:  <span id="PNumber"></span> </p>
                            <p class="text-xs mx-0 my-1 ">Email:  <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1 ">User ID:  <span id="CId"></span> </p>
                        </div>
                        <div class="col-4">
                            <p class="text-xs mx-0 my-1">Mushak: 6.3</p>
                            <p class="text-xs mx-0 my-1">{{ date('d-m-Y h:i A') }}</p>
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
                        <p class="text-bold text-s my-2 text-dark"> FINAL PAYABLE: Tk. <span id="payable"></span></p>

                        <p class="text-sm mx-0 my-1">❝ Your support means the world to us. Thank you for choosing us for your needs.
                        We value your patronage and are here to assist you anytime ❞</p>
                    </div>
                        <div class="col-12 p-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Close</button>
                <button onclick="PrintPage()" class="btn bg-gradient-success">Print</button>
            </div>
        </div>
    </div>
</div>


<script>

    async function invoiceDetails(cus_id, inv_id){

    document.getElementById('loading-div').classList.remove('d-none');
    document.getElementById('content-div').classList.add('d-none');

        let res = await axios.post("/invoice-details",{cus_id:cus_id, inv_id:inv_id});

    // loader hide, content show
    document.getElementById('loading-div').classList.add('d-none');
    document.getElementById('content-div').classList.remove('d-none');

        document.getElementById('CName').innerText = res.data['customer']['name'];
        document.getElementById('PNumber').innerText = res.data['customer']['phone_number'];
        document.getElementById('CEmail').innerText = res.data['customer']['email'];
        document.getElementById('CId').innerText = res.data['customer']['id'];

        let total = parseFloat(res.data['invoice']['total']);
        let discount = parseFloat(res.data['invoice']['discount']);
        let subtotal = total + discount;
        document.getElementById('subtotal').innerText = subtotal;

        document.getElementById('total').innerText = res.data['invoice']['total'];
        document.getElementById('vat').innerText = res.data['invoice']['vat'];
        document.getElementById('discount').innerText = res.data['invoice']['discount'];
        document.getElementById('payable').innerText = res.data['invoice']['payable'];

        let invoiceList = $('#invoiceList');
            invoiceList.empty();

        res.data['product'].forEach(function (item, index){
            let row = `<tr class="text-xs">
                                <td>${item['product']['name']}</td>
                                <td>${item['product']['price']}</td>
                                <td>${item['quantity']}</td>
                                <td>${item['sale_price']}</td>
                            </tr>`;
                invoiceList.append(row)
        });
        $("#invdetails-modal").modal('show')
}

function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 100);
    }

    getprofile();
    async function getprofile(){

        let res = await axios.get('/user-profile');

        if (res.status===200 && res.data['status'] === 'success'){
            let data = res.data['data'];

            // let fullName = data['first_name']+' '+data['last_name'];

            document.getElementById('userName').innerText = data['first_name'];
            document.getElementById('address2').innerText = data['last_name'];
        }
        else {
                alert('Profile Name not found');
               // return console.log(res);
        }
    }

</script>
