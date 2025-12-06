<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //

    public function allCategory(){
        $allCat = Subcategory::with('category')->latest()->get();
        return response()->json([
            'status' => true,
            'datas' => $allCat
        ]);
    }

    public function create(){
        $categories = Category::latest()->where('status','=','active')->get();
        return view('admin.pages.sub_category.create',compact('categories'));
    }

    public function search_cat($name=null){
        if(trim($name)){
             $datas = Subcategory::with('category')->where('name','like',"%".$name."%")->latest()->get();
        }else{
            $datas = Subcategory::with('category')->latest()->get();
        }
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3',
            'slug' => 'required',
            'category_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $data = $request->only(['name','slug','category_id','meta_title','meta_keyword','meta_description']);
        $data['created_by'] = $request->ip();

        Subcategory::create($data);
        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Category!",
            'datas' => Subcategory::with('category')->latest()->get()
        ]);

    }

    public function update(Request $request,int $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3',
            'slug' => 'required',
            'category_id' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $editItem = Subcategory::findOrFail($id);
        $data = $request->only(['name','slug','category_id','meta_title','meta_keyword','meta_description']);
        $editItem->update($data);
        return response()->json([
            'status' => true,
            'datas' => Subcategory::with('category')->latest()->get(),
            'message' => "Successfully Updated Category"
        ]);
    }

    public function destroy(int $id){

        $data = Subcategory::findOrFail($id);
      

        //unlink file
        
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => "Successfully Deleted SubCategory"
        ]);
    }
}
