<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Str;
use App\Booking;

class StrController extends Controller
{
    public function __construct()
    {
		$this->str = new Str();
		$this->booking = new Booking();
    }
    public function index()
    {
		$str = $this->str->str_list();
		$count = $str->count();
		$global_st = $this->booking->global_st();
		return view('str/list',['booking'=>$str,'count'=>$count,'global_st'=>$global_st]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$str = $this->str->str_search($from_date,$to_date);
		$count = $str->count();
		$global_st = $this->booking->global_st();
		return view('str/list',['booking'=>$str,'count'=>$count,'global_st'=>$global_st]);
    }
}
