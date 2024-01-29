<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage(Request $request){
        return view('pages.category.category-page');
    }

    function CategoryList(Request $request){
        $user_id = $request->header('id');
        return category::where('user_id', $user_id)->get();
    }

    function CategoryCreate(Request $request){
        $user_id = $request->header('id');
    return category::create([
            'name'=>$request->input('name'),
            'user_id'=>$user_id
        ]);
    }

    function CategoryUpdate(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name'=>$request->input('name'),
        ]);
    }

    function CategoryDelete(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return category::where('id', $category_id)->where('user_id', $user_id)->delete();
    }

    function CategoryUpdateById(Request $request){
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return category::where('id', $category_id)->where('user_id', $user_id)->first();
    }


}
