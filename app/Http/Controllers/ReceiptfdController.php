<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receiptfd;
use App\Receipt;

class ReceiptfdController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receipt();
		$this->receiptfd = new Receiptfd();
    }
    public function index()
    {
		$receipt = $this->receiptfd->receipt_list();
		$count = $receipt->count();
		$global_st = $this->receipt->global_st();
		$global_vat = $this->receipt->global_vat();
		return view('receipt-fd/list',['receipt'=>$receipt,'count'=>$count,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
    public function add()
    {
		return view('receipt-fd/add');
    }
    public function save(Request $request)
    {
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$fd_principal_amt = $request->input('fd_principal_amt');
		$fd_interest = $request->input('fd_interest');
		$tds = $request->input('tds');
		
		if(empty($booking_no)){
			$this->validate($request,[
				'payment_mode'=>'required',
				'party_name'=>'required',
				'fd_principal_amt'=>'required',
			]);	
		}
		else{
			$this->validate($request,[
				'payment_mode'=>'required'
			]);
		}
		
		$result = $this->receiptfd->receipt_add($party_name,$party_gstin,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$fd_principal_amt,$fd_interest,$tds);
		
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
