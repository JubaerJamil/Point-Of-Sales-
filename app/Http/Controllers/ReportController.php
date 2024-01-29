<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    function reportpage(Request $request){
        return view('pages.report.reportdownload-page');
    }

    function salesreport(Request $request){
        $user_id = $request->header('id');
        $FormDate = date('Y-m-d', strtotime($request->FormDate));
        $ToDate = date('Y-m-d', strtotime($request->ToDate));

        $total = invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat = invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $discount = invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');
        $payable = invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');

        $list = invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)
                ->with('customer')->get();

        $data= [
            'FormDate' => $request->FormDate,
            'ToDate' => $request->ToDate,
            'total' => $total,
            'vat' => $vat,
            'discount' => $discount,
            'payable' => $payable,
            'list' => $list
        ];

        $pdf = pdf::loadView('pages.report.salesreport',$data);

        return $pdf->download('Invoice.pdf');

    }
}
