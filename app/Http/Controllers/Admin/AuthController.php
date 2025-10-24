<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function index(){

        return view('admin.login');
    }

    public function authenticate(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = $request->only(['username','password']);

        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
            if(Auth::user()->type == 'user'){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->with('danger',"You Are Not Admin");
            }
        }else{
            return redirect()->back()->with('danger',"Creadential Incorrect!");
        }

    }

    public function adminLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }




}
