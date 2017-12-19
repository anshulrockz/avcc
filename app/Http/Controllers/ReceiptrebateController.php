<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receiptrebate;

class ReceiptrebateController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receiptrebate();
    }
    public function index()
    {
		$receipt = $this->receipt->receipt_list();
		$count = $receipt->count();
		return view('receipt-rebate/list',['receipt'=>$receipt,'count'=>$count]);
    }
    public function add()
    {
		return view('receipt-rebate/add');
    }
    public function save(Request $request)
    {
		$receipt_no = $request->input('receipt_no');
		$membership_no = $request->input('membership_no');
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$reverse_charges = $request->input('reverse_charges');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$function_date = $request->input('function_date');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		
		$safai = $request->input('safai');
		$tentage = $request->input('tentage');
		$catering = $request->input('catering');
		$food = $request->input('food');
		$electricity = $request->input('electricity');
		
		$this->validate($request,[
			'receipt_no'=>'required',
			'payment_mode'=>'required',
		]);
		
		$result = $this->receipt->receipt_add($receipt_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$safai,$tentage,$catering,$food,$electricity);
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
	public function ajax(Request $request)
    {
		$receipt_no = $request->input('receipt_no');
		$this->receipt->receiptrebate_ajax($receipt_no);
	}
}
