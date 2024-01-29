<?php

namespace App\Http\Controllers;

use App\Models\product;
use Ramsey\Uuid\Type\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    function productpage(Request $request){
        return view('pages.product.product-page');
    }

    function productCreate(Request $request){

        $user_id = $request->header('id');

        $img = $request->file('img_url');
        $time = time();
        $org_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$time}-{$org_name}";
        $img_url = "uploads/{$img_name}";

        // upload image
        $img->move(public_path('uploads'),$img_name);


        return product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id
        ]);
    }

    function productList(Request $request){
        $user_id = $request->header('id');
        return product::where('user_id', $user_id)->get();
    }

    function productDelete(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        $filepath = $request->input('file_path');
        File::delete($filepath);
        return product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }

    function productUpdate(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img_url')){

            // file upload
            $img = $request->file('img_url');
            $time = time();
            $org_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$time}-{$org_name}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // old file delete
            $filepath = $request->input('file_path');
            File::delete($filepath);

            // update product
            return product::where('id', $product_id)->where('user_id', $user_id)->update
            ([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);
        }else {
            return product::where('id', $product_id)->where('user_id', $user_id)->update
            ([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id')
            ]);
        }
    }

    function productById(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return product::where('id', $product_id)->where('user_id', $user_id)->first();
    }
}
