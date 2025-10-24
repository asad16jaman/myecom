<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;

class UserController extends Controller
{
    //

    public function create(){
        return view('admin.pages.user.create');
    }

    public function allUsers(){
        return response()->json([
            'status' => true,
            'datas' => User::latest()->get()
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users,username',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ]
            );
        }

        $data = $request->only(['username','email','password']);
        User::create($data);
        return  response()->json([
            'status' => true,
            'message' => "successfully Saved All Data...",
            'users' => User::latest()->get()
        ]);
    }

    public  function update(Request $request,int $id){

        
        $validator =  Validator::make($request->all(),[
            'username' => "required|unique:users,username,$id",
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $data = $request->only(['username','email']);
        User::where('id',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => "update method a asce..",
            'users' => User::latest()->get()
        ]);
    }

    public function deleteUser(int $id){

            $user = User::find($id);
            if($user){
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => "Successfully Deleted User!",
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "User Not Found"
                ]);
            }
            

            
        
    }




}
