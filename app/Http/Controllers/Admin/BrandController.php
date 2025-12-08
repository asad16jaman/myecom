<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //

    public function allbrands(){
        $datas = Brand::where('status','1')->get();
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
    }

    public function search($name=null){
        if(trim($name)){
             $datas = Brand::where('name','like',"%".$name."%")->latest()->get();
        }else{
            $datas = Brand::latest()->get();
        }
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
    }
    public function create(){

        return view('admin.pages.brand.create');
    }

    public function store(Request $request){
        
        $validat = Validator::make($request->all(),[
            'name' => 'required|string',
            'slug' => 'required'
        ]);

        if($validat->fails()){
             return response()->json([
                'status' => false,
                'errors' => $validat->errors()
            ]);
        }

        $data = $request->only(['name','slug']);
        $data['created_by'] = $request->ip();
        Brand::create($data);
        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Brand!",
            'datas' => Brand::latest()->get()
        ]);
    }

    public function update(Request $request,int $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3',
            'slug' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        $editItem = Brand::findOrFail($id);
        $data = $request->only(['name','slug']);
        $editItem->update($data);
        return response()->json([
            'status' => true,
            'datas' => Brand::latest()->get(),
            'message' => "Successfully Updated Brand"
        ]);
    }







    public function destroy(int $id){

        $data = Brand::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => "Successfully Deleted Brand"
        ]);

    }

}
