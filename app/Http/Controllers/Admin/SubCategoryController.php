<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //

    public function allCategory(){
        $allCat = Subcategory::latest()->get();
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
             $datas = Subcategory::where('title','like',"%".$name."%")->latest()->get();
        }else{
            $datas = Subcategory::latest()->get();
        }
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
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
        $title = $request->slug;
        $fileName = $this->fileUpload($request,'img','uploads/category',$title);
        $data = $request->only(['title','slug','status']);
        $data['img'] = $fileName;
        Subcategory::create($data);
        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Category!",
            'datas' => Subcategory::latest()->get()
        ]);
    }

    public function update(Request $request,int $id){

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
        $editItem = Subcategory::findOrFail($id);
        $data = $request->only(['title','slug','status']);
        if($request->hasFile('img')){
            //unlink file
            if(file_exists(public_path($editItem->img))){
                unlink(public_path($editItem->img));
            }
            //upload new file
            $title = $request->slug;
            $fileName = $this->fileUpload($request,'img','uploads/category',$title);
            $data['img'] = $fileName;
        }
        $editItem->update($data);
        return response()->json([
            'status' => true,
            'datas' => Subcategory::latest()->get(),
            'message' => "Successfully Updated Category"
        ]);
    }

    public function destroy(int $id){
        $data = Subcategory::findOrFail($id);
        //unlink file
        if(file_exists(public_path($data->img))){
            unlink(public_path($data->img));
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => "Successfully Deleted Category"
        ]);
    }
}
