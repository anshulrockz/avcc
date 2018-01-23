<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Receipt;
use App\Member;
use App\Membertype;
use App\Facility;
use App\Contractor;
use App\Receiptrebate;

class ReceiptController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receipt();
		$this->receiptrebate = new Receiptrebate();
		$this->member = new Member();
		$this->membertype = new Membertype();
		$this->facility = new Facility();
		$this->contractor = new Contractor();
    }
    public function index()
    {
		$receipt = $this->receipt->receipt_list();
		$count = $receipt->count();
		return view('receipt/list',['receipt'=>$receipt,'count'=>$count]);
    }
    public function add()
    {
		$membertype = $this->membertype->membertype_list();
		$facility = $this->facility->facility_list();
		$member = $this->member->member_list();
		$member_type = $this->membertype->membertype_list();
		$contractor = $this->contractor->contractor_list();
		return view('receipt/add',['membertype'=>$membertype,'facility'=>$facility,'member'=>$member,'member_type'=>$member_type,'contractor'=>$contractor]);
    }
    public function save(Request $request)
    {
		$booking_no = $request->input('booking_no');
		$membership_no = $request->input('membership_no');
		$party_name = $request->input('party_name');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$function_date = $request->input('function_date');
		$contractor = $request->input('contractor');
		$est_cof = $request->input('est_cof');
		$vat_supplier = $request->input('vat_supplier');
		$est_catering = $request->input('est_catering');
		$vat_caterer = $request->input('vat_caterer');
		$st_caterer = $request->input('st_caterer');
		$est_tentage = $request->input('est_tentage');
		$vat_tent = $request->input('vat_tent');
		$st_tent = $request->input('st_tent');
		
		$this->validate($request,[
			'payment_mode'=>'required',
			'contractor'=>'required'
		]);
		
		if(empty($booking_no)){
			$this->validate($request,[
				'payment_mode'=>'required',
				'contractor'=>'required',
				'party_name'=>'required'
			]);	
		}
		else{
			$this->validate($request,[
				'payment_mode'=>'required',
				'contractor'=>'required'
			]);
		}
		
		$result = $this->receipt->receipt_add($booking_no,$party_name,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$contractor,$est_cof,$vat_supplier,$est_catering,$vat_caterer,$st_caterer,$est_tentage,$vat_tent,$st_tent);
		
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
		$receipt = $this->receipt->receipt_tentage($id);
		
		if($receipt[0]->receipt_type == '1'){
			$receipt = $this->receipt->receipt_booking($id);
			$facility = $this->receipt->facility($id);
			return view('receipt/view',['receipt'=>$receipt,'contractor'=>$this->contractor, 'facility' => $facility]);
		}
		
		if($receipt[0]->receipt_type == '3'){
			$receipt = $this->receipt->receipt_tentage($id);
		}
		
		if($receipt[0]->receipt_type == '4'){
			$receipt = $this->receipt->receipt_catering($id);
		}
		
		if($receipt[0]->receipt_type == '5'){
			$receipt = $this->receipt->receipt_rent($id);
		}
		
		if($receipt[0]->receipt_type == '6'){
			$receipt = $this->receipt->receipt_corpusfund($id);
		}
		
		if($receipt[0]->receipt_type == '8'){
			$receipt = $this->receipt->receipt_rebate($id);
		}
		
		if($receipt[0]->receipt_type == '9'){
			$receipt = $this->receipt->receipt_fd($id);
		}
		
		if($receipt[0]->receipt_type == '10'){
			$receipt = $this->receipt->receipt_others($id);
		}
		
		return view('receipt/view',['receipt'=>$receipt,'contractor'=>$this->contractor]);
    }
    
    public function cancel(Request $request,$id)
    {
		$result = $this->receipt->receipt_cancel($id);
		if($result){
			$request->session()->flash('success', 'Receipt cancelled successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
	
	public function bookingdetails_ajax(Request $request)
    {
		$booking_no = $request->input('booking_no');
		$refund_type = $request->input('refund_type');
		$this->receipt->bookingdetails_ajax($booking_no,$refund_type);
	}
	
	public function viewOld($id)
    {
		$receipt = $this->receipt->receipt_edit($id);
		$receipt_facility = $this->receipt->receipt_facility($id);
		$total_receiptamount = $this->receipt->total_receiptamount($id);
		$safai_charges = $this->receipt->safai_charges($id);
		$generator_charges = $this->receipt->generator_charges($id);
		$ac_charges = $this->receipt->ac_charges($id);
		
		$security_charges = $this->receipt->security_charges($id);
		$other_charges = $this->receipt->other_charges($id);
		$sub_total = $this->receipt->sub_total($id);
		$servicetax_total = $this->receipt->servicetax_total($id);
		$vat_total = $this->receipt->vat_total($id);
		
		$global_st = $this->receipt->global_st();
		$global_vat = $this->receipt->global_vat();
		
		$rebate = $this->receipt->getRebate($receipt[0]->booking_no);
		
		return view('receipt/view_old',['receipt'=>$receipt,'booking_facility'=>$receipt_facility,'total_receiptamount'=>$total_receiptamount,'safai_charges'=>$safai_charges,'generator_charges'=>$generator_charges,'ac_charges'=>$ac_charges,'security_charges'=>$security_charges,'sub_total'=>$sub_total,'servicetax_total'=>$servicetax_total,'vat_total'=>$vat_total,'global_st'=>$global_st,'global_vat'=>$global_vat,'contractor'=>$this->contractor,'rebate'=>$rebate]);
    }
    
}
