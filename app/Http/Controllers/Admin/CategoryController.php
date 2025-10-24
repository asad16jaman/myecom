<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function allCategory(){
        $allCat = Category::latest()->get();
        return response()->json([
            'status' => true,
            'datas' => $allCat
        ]);
    }
    public function create(){

        return view('admin.pages.category.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|min:3',
            'slug' => 'required',
            'status' => 'required',
            'img' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $title = $request->title;
        $fileName = $this->fileUpload($request,'img','uploads/category',$title);
        $data = $request->only(['title','slug','status']);
        $data['img'] = $fileName;
        Category::create($data);

        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Category!",
            'datas' => Category::latest()->get()
        ]);
    }







}
