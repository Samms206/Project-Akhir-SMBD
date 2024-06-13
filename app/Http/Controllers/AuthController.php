<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function loginProses(Request $request){
        $user = DB::select('SELECT * FROM `users` WHERE email=? AND `password` = ?', [$request->email, $request->password]);
        if($user){
            $request->session()->put([
                'is_admin' => $user[0]->is_admin ? 'yes' : 'no',
                'user_id' => $user[0]->id,
                'username' => $user[0]->name
            ]);
            return redirect('/')->with('success', 'Login Success');
        }else{
            return redirect()->back()->with("Email or Password not match!")->withInput();
        }
    }

    public function logout(){
        session()->forget('is_admin');
        Auth::logout();
        return redirect('/login')->with('warning', 'Logout Success');
    }
}
