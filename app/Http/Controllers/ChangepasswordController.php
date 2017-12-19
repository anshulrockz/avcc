<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChangepasswordController extends Controller
{
    public function index()
    {
		return view('changepassword');
    }
    public function save(Request $request)
    {
		$old_password = $request->input('old_password');
		$password = $request->input('password');
		$confirm_password = $request->input('confirm_password');

		$this->validate($request,[
			'old_password'=>'required',
			'password'=>'required|min:6|same:confirm_password',
			'confirm_password'=>'required'
		]);
		
		$user_id = Auth::id();
		$oldpassword_db = Auth::user()->password;
		$updated_at = Carbon::now('Asia/Kolkata');
		
		if(Hash::check($old_password, $oldpassword_db)){
			$new_password = Hash::make($password);
			DB::update('update users set password = ?,updated_at = ? where id = ?',[$new_password,$updated_at,$user_id]);
			$request->session()->flash('success', 'Password changed successfully.');
		}
		else{
			$request->session()->flash('failed', 'Old Password does not match the record.');
		}
    	return redirect()->back();
    }
}
