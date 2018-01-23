<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Refundvoucher;

class RefundvoucherController extends Controller
{
    public function __construct()
    {
		$this->refundvoucher = new Refundvoucher();
    }
    public function index()
    {
		$refundvoucher = $this->refundvoucher->refundvoucher_list();
		$count = $refundvoucher->count();
		return view('refundvoucher/list',['refundvoucher'=>$refundvoucher,'count'=>$count]);
    }
    public function add()
    {
		$refundvoucher = DB::table('refundvoucher')->orderBy('id', 'desc')->first();
		$refundvoucher_id = 0;
		if(!empty($refundvoucher)){
			$refundvoucher_id = $refundvoucher->id;
		}
		return view('refundvoucher/add',['voucher_id'=>$refundvoucher_id]);
    }
    public function save(Request $request)
    {
		$receipt_id = $request->input('receipt_no');
		$voucher_date = $request->input('voucher_date');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$refund_type = $request->input('refund_type');
		
		$this->validate($request,[
			'voucher_date'=>'required|date',
			'refund_type'=>'required',
			'receipt_no'=>'required',
			'payment_mode'=>'required'
		]);
		
		$result = $this->refundvoucher->refundvoucher_add($refund_type,$receipt_id,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
		if($result){
			$request->session()->flash('success', 'Voucher created successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function partialcancel()
    {
		$token = '';
		if(isset($_GET['token'])){
			$token = $_GET['token'];
		}
		
		$receipt = $this->refundvoucher->receipt($token); 
		$receiptfacility = $this->refundvoucher->receiptfacility($token);
		//dd($receiptfacility); die();
		$refundvoucher = DB::table('refundvoucher')->orderBy('id', 'desc')->first();
		$refundvoucher_id = 0;
		if(!empty($refundvoucher)){
			$refundvoucher_id = $refundvoucher->id;
		}
		return view('refundvoucher/partialcancel',['receipt'=>$receipt,'receiptfacility'=>$receiptfacility,'voucher_id'=>$refundvoucher_id]);
    }
    public function partialupdate(Request $request,$id)
    {
		$voucher_date = $request->input('voucher_date');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		
		$facility = $request->input('facility_id');
		$booking_rate = $request->input('booking_rate');
		$quantity = $request->input('quantity');
		$no_of_days = $request->input('no_of_days');
		$amount = $request->input('amount');
		$deduction = $request->input('deduction');
		$misc_deduction = $request->input('misc_deduction');
		$others_deduction = $request->input('others_deduction');

		$result = $this->refundvoucher->partial_update($id,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$facility,$booking_rate,$quantity,$no_of_days,$amount,$deduction,$misc_deduction,$others_deduction);
		
		if($result){
			$request->session()->flash('success', 'Voucher created successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->action('RefundvoucherController@index');
    }
	public function view($id)
    {
		$refundvoucher = $this->refundvoucher->refundvoucher_view($id);
		$refund_facility = $this->refundvoucher->refund_facility($id);
		$receipt_id = $this->refundvoucher->getReceiptID($id);
		return view('refundvoucher/view',['voucher'=>$refundvoucher,'refund_facility'=>$refund_facility]);
    }
}