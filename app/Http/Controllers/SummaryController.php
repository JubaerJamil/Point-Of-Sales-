<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\product;
use App\Models\category;
use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SummaryController extends Controller
{
    function summarypage(Request $request):View{
        return view('pages.summary.dashboard-summary-page');
    }


    function summary(Request $request):array {

        $user_id = $request->header('id');

        $product = product::where('user_id', $user_id)->count();
        $category = category::where('user_id', $user_id)->count();
        $customer = customer::where('user_id', $user_id)->count();
        $invoice = invoice::where('user_id', $user_id)->count();
        $todaysale = invoice::where('user_id', $user_id)->whereDate('created_at', now()->format('Y-m-d'))->sum('total');
        $todaydiscount = invoice::where('user_id', $user_id)->whereDate('created_at', now()->format('Y-m-d'))->sum('discount');
        $totalsale = invoice::where('user_id', $user_id)->sum('total');
        $vat = invoice::where('user_id', $user_id)->sum('vat');
        $totalcollection = invoice::where('user_id', $user_id)->sum('payable');

        return [
            'product' => $product,
            'category' => $category,
            'customer' => $customer,
            'invoice' => $invoice,
            'todaysale' => round($todaysale,2),
            'discount' => round($todaydiscount,2),
            'totalsale' => round($totalsale,2),
            'vat' => round($vat,2),
            'totalcollection' => round($totalcollection,2),
        ];

    }
}
