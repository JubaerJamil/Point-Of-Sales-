<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    //customer font-end page
    function customerPage(Request $request){
        return view('pages.customer.customer-page');
    }


    // function customerUpdatePage(Request $request){
    //     return view('pages.customer.customerCreate');
    // }

    // function customerDeletePage(Request $request){
    //     return view('pages.customer.customerCreate');
    // }

    //customer API
    function customerList(Request $request) {
        $user_id = $request->header('id');
        return customer::where('user_id', $user_id)->get();
    }

    function customerCreate(Request $request) {
        $user_id = $request->header('id');
        return customer::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'user_id' => $user_id
        ]);
    }

    function customerDelete(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return customer::where('id', $customer_id)->where('user_id', $user_id)->delete();
    }

    function customerUpdate(Request $request) {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return customer::where('id', $customer_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email')
        ]);
    }

    function customerById(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return customer::where('id', $customer_id)->where('user_id', $user_id)->first();
    }

}
