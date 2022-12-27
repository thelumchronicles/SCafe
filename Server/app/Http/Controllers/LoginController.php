<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session; 

class LoginController extends Controller
{
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $res){
        $user = DB::table('user')->where("user_name" , $res->username)->where("user_password" , $res->password) ->first();
        if ($user == null) {
            return redirect()->route('getLogin')->with('error-notification' , "Sai tài khoản hoặc mật khẩu!!!");
        }
        else {
            Session::put('user_id' , $user->user_id);
            Session::put('user_name', $user->user_name);
            Session::put('user_fullname' , $user->user_fullname);
            if ($user->user_gender == 0) {
                Session::put('user_gender', "Nam");
            }
            else {
                Session::put('user_gender', "Nữ");
            }

            Session::put('user_image' , $user->user_image);
            Session::put('user_permission', $user->user_permission);
            Session::put('logged', 1);
            return redirect()->route('mainIndex');
        }    
    }

    public function logout(){
        Session::flush();
        return redirect()->route("mainIndex");
    }
}
