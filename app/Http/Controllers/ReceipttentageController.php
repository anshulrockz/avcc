<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receipttentage;
use App\Contractor;

class ReceipttentageController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receipttentage();
		$this->contractor = new Contractor();
    }
    public function index()
    {
		$receipt = $this->receipt->receipt_list();
		$count = $receipt->count();
		return view('receipt-tentage/list',['receipt'=>$receipt,'count'=>$count]);
    }
    public function old()
    {
		$receipt = $this->receipt->receipt_list();
		$count = $receipt->count();
		return view('receipt-tentage/list_old',['receipt'=>$receipt,'count'=>$count]);
    }
    public function add()
    {
		$contractor = $this->contractor->contractor_list();
		return view('receipt-tentage/add',['contractor'=>$contractor]);
    }
    public function save(Request $request)
    {
		$booking_no = $request->input('booking_no');
		$membership_no = $request->input('membership_no');
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$reverse_charges = $request->input('reverse_charges');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$function_date = $request->input('function_date');
		$function_time = $request->input('function_time');
		$contractor = $request->input('contractor');
		$cost_tentage = $request->input('cost_tentage');
		$security_deposit = $request->input('security_deposit');
		$comments = $request->input('comments');
		
		if(empty($booking_no)){
			$this->validate($request,[
				'payment_mode'=>'required',
				'contractor'=>'required',
				'function_date'=>'required',
				'function_time'=>'required',
			]);
		}
		else{
			$this->validate($request,[
				'payment_mode'=>'required',
				'contractor'=>'required',
			]);
		}
		if(!empty($function_date)){
			$function_date = date_format(date_create($function_date),"Y-m-d");
		}
		if(!empty($cheque_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		$result = $this->receipt->receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$function_time,$contractor,$cost_tentage,$security_deposit,$comments);
		
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
}
