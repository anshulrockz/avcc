<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receiptrent;
use App\Receipt;

class ReceiptrentController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receipt();
		$this->receiptrent = new Receiptrent();
    }
    public function index()
    {
		$receipt = $this->receiptrent->receipt_list();
		$count = $receipt->count();
		$global_st = $this->receipt->global_st();
		$global_vat = $this->receipt->global_vat();
		return view('receipt-rent/list',['receipt'=>$receipt,'count'=>$count,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
    public function add()
    {
		return view('receipt-rent/add');
    }
    public function save(Request $request)
    {
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
		$rent_premises = $request->input('rent_premises');
		$rent_store = $request->input('rent_store');
		$rent_atm = $request->input('rent_atm');
		$tds = $request->input('tds');
		$with_tax = $request->input('with_tax');
		
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
		
		$result = $this->receiptrent->receipt_add($party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax);
		
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
