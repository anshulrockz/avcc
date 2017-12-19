<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
		$booking_no = $request->input('booking_no');
		$voucher_date = $request->input('voucher_date');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$refund_type = $request->input('refund_type');
		
		$this->validate($request,[
			'booking_no'=>'required',
			'voucher_date'=>'required|date',
			'refund_type'=>'required',
			'payment_mode'=>'required'
		]);
		
		$result = $this->refundvoucher->refundvoucher_add($refund_type,$booking_no,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
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
		$booking_no = '';
		if(isset($_GET['token'])){
			$booking_no = $_GET['token'];
		}
		$booking = $this->refundvoucher->booking($booking_no);
		$bookingfacility = $this->refundvoucher->bookingfacility($booking_no);
		return view('refundvoucher/partialcancel',['bookingfacility'=>$bookingfacility,'booking'=>$booking,'booking_no'=>$booking_no]);
    }
    public function partialupdate(Request $request,$id)
    {
		$facility_checked = $request->input('facility_checked');
		$facility_hidden = $request->input('facility_hidden');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$receipt_id = $request->input('receipt_id');
		
		//echo "<pre>";
//		print_r($facility_checked);
//		die;

		if(count($facility_hidden) == count($facility_checked)){
			$request->session()->flash('error', 'For full cancellation, Go to booking section!');
			return redirect()->back();
		}
		elseif(count($facility_checked) == 0){
			$request->session()->flash('error', 'Something went wrong!');
			return redirect()->back();
		}
		else{
			$result = $this->refundvoucher->refundvoucher_update($receipt_id,$id,$facility_checked,$facility_hidden,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
			if($result){
				$request->session()->flash('success', 'Voucher created successfully!');
			}
			else{
				$request->session()->flash('error', 'Something went wrong!');
			}
			return redirect()->action('RefundvoucherController@index');
		}
    }
	public function view($id)
    {
		$refundvoucher = $this->refundvoucher->refundvoucher_view($id);
		$refund_facility = $this->refundvoucher->refund_facility($id);
//		print_r($refund_details);
//		die;
		return view('refundvoucher/view',['voucher'=>$refundvoucher,'refund_facility'=>$refund_facility]);
    }
    public function bookingdetails_ajax(Request $request)
    {
		$booking_no = $request->input('booking_no');
		$refund_type = $request->input('refund_type');
		$this->refundvoucher->bookingdetails_ajax($booking_no,$refund_type);
	}
}
