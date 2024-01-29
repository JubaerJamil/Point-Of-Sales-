<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\invoice;
use App\Models\customer;
use Illuminate\Http\Request;
use App\Models\invoice_products;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    function invoicepage (Request $request){
        return view('pages.invoice.create-invoice-page');
    }

    function invoiclist (Request $request){
        return view('pages.invoice.invoice-list-page');
    }

    function invoiceCreate (Request $request) {

        DB::beginTransaction();

        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = invoice::create ([
                'total'=>$total,
                'discount'=>$discount,
                'vat'=>$vat,
                'payable'=>$payable,
                'user_id'=>$user_id,
                'customer_id'=>$customer_id,
            ]);

            $invoiceId = $invoice->id;

            $products = $request->input('products');

            foreach ($products as $eachProduct) {
                invoice_products::create([
                    'invoice_id' => $invoiceId,
                    'user_id' => $user_id,
                    'product_id' => $eachProduct['product_id'],
                    'quantity' => $eachProduct['quantity'],
                    'sale_price' => $eachProduct['sale_price'],
                ]);
            }
            DB::commit();
                return 1;
        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }


    function invoiceSelect(Request $request) {
        $user_id = $request->header('id');
        return invoice::where('user_id', $user_id)->with('customer')->get();
    }


    function invoiceDetails(Request $request) {
        $user_id = $request->header('id');
        $customer_details = customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->First();

        $invoiceTotal =  invoice::where('user_id', $user_id)->where('id', $request->input('inv_id'))->First();

        $productDetails = invoice_products::where('invoice_id', $request->input('inv_id'))->where('user_id', $user_id)->with('product')->get();

        return array (
            'customer' => $customer_details,
            'invoice' => $invoiceTotal,
            'product' => $productDetails,
        );
    }

    function invoiceDelete (Request $request){
        DB::beginTransaction();

        try{
                $user_id = $request->header('id');

                invoice_products::where('user_id', $user_id)->where('invoice_id', $request->input('inv_id'))->delete();

                invoice::where('id', $request->input('inv_id'))->delete();

            DB::commit();
            return 1;

        }
        catch(Exception $e) {
            DB::rollBack();
            return 0;
        };
    }




}
