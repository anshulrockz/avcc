<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EditprofileController extends Controller
{
    public function index()
    {
		$user_id = Auth::id();
		$profile = DB::select('select * from users where id = ?',[$user_id]);
		return view('editprofile',['profile'=>$profile]);
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$email = $request->input('email');
		$mobile = $request->input('mobile');
		$image = $request->file('image');
		$user_id = Auth::id();
		$updated_at = Carbon::now('Asia/Kolkata');

		$this->validate($request,[
			'name'=>'required',
			'email'=>'required|email',
			'mobile'=>'required|digits:10',
			'image' => 'image|max:2048'
		]);
		
		if($image){
		    $image_name = time().'.'.$image->getClientOriginalExtension();
		    $image->move(public_path('uploads'), $image_name);
		    DB::update('update users set name = ?,email = ?,mobile = ?,image = ?,updated_at = ? where id = ?',[$name,$email,$mobile,$image_name,$updated_at,$user_id]);
		}
		else{
			DB::update('update users set name = ?,email = ?,mobile = ?,updated_at = ? where id = ?',[$name,$email,$mobile,$updated_at,$user_id]);
		}
		
		$request->session()->flash('status', 'Your Profile has been successfully updated.');
    	return redirect()->back();
    }
}
