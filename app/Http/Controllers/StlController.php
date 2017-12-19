<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Stl;
use App\Booking;
use App\Member;
use App\Membertype;
use App\Facility;

class StlController extends Controller
{
    public function __construct()
    {
		$this->stl = new Stl();
		$this->booking = new Booking();
		$this->member = new Member();
		$this->membertype = new Membertype();
		$this->facility = new Facility();
    }
    public function index()
    {
		$stl = $this->stl->stl_list();
		$count = $stl->count();
		return view('receipt-stl/list',['booking'=>$stl,'count'=>$count]);
    }
    public function save(Request $request,$id)
    {
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$this->validate($request,[
			'payment_mode'=>'required',
		]);
		$result = $this->stl->receipt_create($id,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
		if($result){
			return redirect()->action(
			    'ReceiptController@view', ['id' => $result]
			);
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
			return redirect()->back();
		}
    }
    public function view($id)
    {
		$booking = $this->stl->stl_view($id);
		$global_st = $this->booking->global_st();
		$global_vat = $this->booking->global_vat();
		return view('receipt-stl/view',['booking'=>$booking,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
}
