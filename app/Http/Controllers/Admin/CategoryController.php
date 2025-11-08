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

    public function search_cat($name=null){

        if(trim($name)){
             $datas = Category::where('title','like',"%".$name."%")->latest()->get();
        }else{
            $datas = Category::latest()->get();
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
        Category::create($data);

        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Category!",
            'datas' => Category::latest()->get()
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

        $editItem = Category::findOrFail($id);

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
            'datas' => Category::latest()->get(),
            'message' => "Successfully Updated Category"
        ]);
    }

    public function destroy(int $id){
        $data = Category::findOrFail($id);
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
