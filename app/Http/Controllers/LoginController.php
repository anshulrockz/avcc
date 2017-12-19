<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
		if(Auth::check()){
			return redirect('/');
		}
		else{
			return view('login');
		}
    }
    public function login(Request $request)
    {
		$email = $request->input('email');
		$password = $request->input('password');
		$this->validate($request,[
			'email'=>'required|email',
			'password'=>'required|min:6'
		]);
		if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            return redirect('/');
        }
        else{
        	$request->session()->flash('status', 'Invalid E-mail or Password!');
			return redirect()->back();
		}
    }
}
