<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receiptothers;
use App\Receipt;

class ReceiptothersController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receipt();
		$this->receiptothers = new Receiptothers();
    }
    public function index()
    {
		$receipt = $this->receiptothers->receipt_list();
		$count = $receipt->count();
		$global_st = $this->receipt->global_st();
		$global_vat = $this->receipt->global_vat();
		return view('receipt-others/list',['receipt'=>$receipt,'count'=>$count,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
    public function add()
    {
		return view('receipt-others/add');
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
		$security_deposit = $request->input('security_deposit');
		$corpus_fund = $request->input('corpus_fund');
		$others = $request->input('misc');
		$withtax = $request->input('with_tax');
		$comments = $request->input('comments');
		
		if(empty($booking_no)){
			$this->validate($request,[
				'payment_mode'=>'required',
				'party_name'=>'required',
				'reverse_charges'=>'required'
			]);	
		}
		else{
			$this->validate($request,[
				'payment_mode'=>'required'
			]);
		}
		$result = $this->receiptothers->receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$others,$withtax,$comments);
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
