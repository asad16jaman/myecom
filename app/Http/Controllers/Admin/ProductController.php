<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function create(){
        $categories = Category::all();
        $subcategory = Subcategory::all();
        $brands = Brand::all();
         return view('admin.pages.product.create',compact('categories','subcategory','brands'));
    }
}
