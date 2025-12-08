<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    //

    public function allColor(){
        $datas = Color::where('status','1')->get();
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
    }

    public function search($name = null){
         if(trim($name)){
             $datas = Color::where('name','like',"%".$name."%")->orWhere('code','=',$name)->latest()->get();
        }else{
            $datas = Color::latest()->get();
        }
        return response()->json([
            'status' => true,
            'datas' => $datas
        ]);
    }

    public function create(){
         return view('admin.pages.color.create');
    }
    

    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            'name' => 'nullable|string'
        ]);
        if($validate->fails()){
             return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
        $data = $request->only(['name','code']);
        $data['created_by'] = $request->ip();
        Color::create($data);
        return response()->json([
            'status' => true,
            'message' => "Successfully Stored Colour!",
            'datas' => Color::latest()->get()
        ]);



    }

    public function update(Request $request,int $id){
        $validate = Validator::make($request->all(),[
            'name' => 'nullable|string'
        ]);
        if($validate->fails()){
             return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }

        $data = $request->only(['name','code']);
        $editItem = Color::findOrFail($id);
        $editItem->update($data);

        return response()->json([
            'status' => true,
            'datas' => Color::latest()->get(),
            'message' => "Successfully Updated Colour"
        ]);

    }


    public function destroy(int $id){

        $data = Color::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => "Successfully Deleted Colour"
        ]);
    }




}
