<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Member;
use App\Membertype;
use App\Facility;

class BookingController extends Controller
{
    public function __construct()
    {
		$this->booking = new Booking();
		$this->member = new Member();
		$this->membertype = new Membertype();
		$this->facility = new Facility();
    }
    public function index()
    {
		$booking = $this->booking->booking_list();
		$count = $booking->count();
		return view('booking/list',['booking'=>$booking,'count'=>$count]);
    }
    public function add()
    {
		$membertype = $this->membertype->membertype_list();
		$facility = $this->facility->facility_list();
		$member = $this->member->member_list();
		$member_type = $this->membertype->membertype_list();
		$booking = DB::table('booking')->orderBy('id', 'desc')->first();
		$booking_id = 0;
		if(!empty($booking)){
			$booking_id = $booking->id;
		}
		return view('booking/add',['membertype'=>$membertype,'facility'=>$facility,'member'=>$member,'member_type'=>$member_type,'booking_id'=>$booking_id]);
    }
    public function save(Request $request)
    {
		$booking_no = $request->input('booking_no');
		$booking_date = $request->input('booking_date');
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$reverse_charges = $request->input('reverse_charges');
		$function_date = $request->input('function_date');
		$from_time = $request->input('from_time');
		$to_time = $request->input('to_time');
		$function_type = $request->input('function_type');
		$bill_no = $request->input('bill_no');
		$bill_date = $request->input('bill_date');
		$membership_no = $request->input('membership_no');
		$is_sponsor = $request->input('sponsor');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$noofpersons = $request->input('noofpersons');
		$misc = $request->input('misc');
		$misc_amount = $request->input('misc_amount');
		$others = $request->input('others');
		$others_amount = $request->input('others_amount');
		
		$facility = $request->input('facility_id');
		$quantity = $request->input('quantity');
		$noofdays = $request->input('noofdays');
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$booking_rate = $request->input('booking_rate');
		$generator_charges = $request->input('generator_charges');
		$ac_charges = $request->input('ac_charges');
		$safai_general = $request->input('safai_general');
		$security_charges = $request->input('security_charges');
		$rebate_safai = $request->input('rebate_safai');
		$rebate_tentage = $request->input('rebate_tentage');
		$rebate_catering = $request->input('rebate_catering');
		$rebate_electricity = $request->input('rebate_electricity');
		$servicetaxPercentage = $request->input('servicetaxPercentage');
		$servicetaxAmount = $request->input('servicetaxAmount');
		$vatPercentage = $request->input('vatPercentage');
		$vatAmount = $request->input('vatAmount');
		$totalAmount = $request->input('totalAmount');
		
		$this->validate($request,[
			'function_date'=>'required|date',
			'membership_no'=>'required'
		]);
		$result = $this->booking->booking_add($booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount);
		if($result){
			return redirect()->action(
			    'BookingController@view', ['id' => $result]
			);
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function view($id)
    {
		$booking = $this->booking->booking_edit($id);
		$booking_facility = $this->booking->booking_facility($id);
		$total_bookingamount = $this->booking->total_bookingamount($id);
		$safai_charges = $this->booking->safai_charges($id);
		$generator_charges = $this->booking->generator_charges($id);
		$ac_charges = $this->booking->ac_charges($id);
		$security_charges = $this->booking->security_charges($id);
		$other_charges = $this->booking->other_charges($id);
		$sub_total = $this->booking->sub_total($id);
		$servicetax_total = $this->booking->servicetax_total($id);
		$vat_total = $this->booking->vat_total($id);
		$is_receiptcreated = $this->booking->is_receiptcreated($id);
		$global_st = $this->booking->global_st();
		$global_vat = $this->booking->global_vat();
		$receipt_status = $this->booking->receipt_status($id);
		return view('booking/view',['booking'=>$booking,'booking_facility'=>$booking_facility,'total_bookingamount'=>$total_bookingamount,'safai_charges'=>$safai_charges,'generator_charges'=>$generator_charges,'security_charges'=>$security_charges,'sub_total'=>$sub_total,'servicetax_total'=>$servicetax_total,'vat_total'=>$vat_total,'is_receiptcreated'=>$is_receiptcreated,'global_st'=>$global_st,'global_vat'=>$global_vat,'receipt_status'=>$receipt_status]);
    }
    public function create_receipt($id)
    {
		$booking = $this->booking->booking_edit($id);
		$booking_facility = $this->booking->booking_facility($id);
		$total_bookingamount = $this->booking->total_bookingamount($id);
		$safai_charges = $this->booking->safai_charges($id);
		$generator_charges = $this->booking->generator_charges($id);
		$security_charges = $this->booking->security_charges($id);
		$sub_total = $total_bookingamount+$safai_charges+$generator_charges+$security_charges;
		return view('booking/create_receipt',['booking'=>$booking,'booking_facility'=>$booking_facility,'total_bookingamount'=>$total_bookingamount,'safai_charges'=>$safai_charges,'generator_charges'=>$generator_charges,'security_charges'=>$security_charges,'sub_total'=>$sub_total]);
//		return view('booking/create_receipt');
    }
    public function change_status(Request $request,$id)
    {
		$with_tax = $request->input('is_tax_checked');
		$with_security = $request->input('is_sec_checked');
		$payment_mode = $request->input('payment_mode');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$cheque_drawn = $request->input('cheque_drawn');
		$result = $this->booking->change_status($id,$with_tax,$with_security,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
		if(!$result){
			$request->session()->flash('error', 'Something went wrong!');
			return redirect()->back();
		}
		else{
			$receipt = DB::table('receipt')->orderBy('id', 'desc')->first();
			$receipt_id = $receipt->id;
			return redirect()->action(
			    'ReceiptController@view', ['id' => $receipt_id]
			);
		}
    }
    public function partialedit($id)
    {
		$booking = $this->booking->booking_edit($id);
		$booking_facility = $this->booking->booking_facility($id);
		$membertype = $this->membertype->membertype_list();
		$facility = $this->facility->facility_list();
		$member = $this->member->member_list();
		$member_type = $this->membertype->membertype_list();
		$receipt_created = $this->booking->receipt_created($id);
		return view('booking/partialedit',['booking'=>$booking,'membertype'=>$membertype,'facility'=>$facility,'member'=>$member,'member_type'=>$member_type,'booking_facility'=>$booking_facility]);
    }
    public function partialupdate(Request $request,$id)
    {
		$booking_no = $request->input('booking_no');
		$booking_date = $request->input('booking_date');
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$reverse_charges = $request->input('reverse_charges');
		$function_date = $request->input('function_date');
		$from_time = $request->input('from_time');
		$to_time = $request->input('to_time');
		$function_type = $request->input('function_type');
		$bill_no = $request->input('bill_no');
		$bill_date = $request->input('bill_date');
		$membership_no = $request->input('membership_no');
		$receipt_created = $this->booking->receipt_created($id);
		$is_sponsor = $request->input('sponsor');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$noofpersons = $request->input('noofpersons');
		$misc = $request->input('misc');
		$misc_amount = $request->input('misc_amount');
		$others = $request->input('others');
		$others_amount = $request->input('others_amount');
		
		$facility = $request->input('facility_id');
		$quantity = $request->input('quantity');
		$noofdays = $request->input('noofdays');
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$booking_rate = $request->input('booking_rate');
		$generator_charges = $request->input('generator_charges');
		$ac_charges = $request->input('ac_charges');
		$safai_general = $request->input('safai_general');
		$security_charges = $request->input('security_charges');
		$rebate_safai = $request->input('rebate_safai');
		$rebate_tentage = $request->input('rebate_tentage');
		$rebate_catering = $request->input('rebate_catering');
		$rebate_electricity = $request->input('rebate_electricity');
		$servicetaxPercentage = $request->input('servicetaxPercentage');
		$servicetaxAmount = $request->input('servicetaxAmount');
		$vatPercentage = $request->input('vatPercentage');
		$vatAmount = $request->input('vatAmount');
		$totalAmount = $request->input('totalAmount');
		
		$this->validate($request,[
			'function_date'=>'required|date',
			'membership_no'=>'required'
		]);
		$booking_id = $this->booking->partial_update($id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$receipt_created,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount);
		if($booking_id){
			return redirect()->action(
			    'BookingController@view', ['id' => $booking_id]
			);
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
    }
    public function edit($id)
    {
		$booking = $this->booking->booking_edit($id);
		$booking_facility = $this->booking->booking_facility($id);
		$membertype = $this->membertype->membertype_list();
		$facility = $this->facility->facility_list();
		$member = $this->member->member_list();
		$member_type = $this->membertype->membertype_list();
		$receipt_created = $this->booking->receipt_created($id);
//		if($receipt_created == '1'){
//			return redirect()->action('BookingController@index');
//		}
//		else{
			return view('booking/edit',['booking'=>$booking,'membertype'=>$membertype,'facility'=>$facility,'member'=>$member,'member_type'=>$member_type,'booking_facility'=>$booking_facility]);
//		}
    }
    public function update(Request $request,$id)
    {
		$booking_no = $request->input('booking_no');
		$booking_date = $request->input('booking_date');
		$party_name = $request->input('party_name');
		$party_gstin = $request->input('party_gstin');
		$reverse_charges = $request->input('reverse_charges');
		$function_date = $request->input('function_date');
		$from_time = $request->input('from_time');
		$to_time = $request->input('to_time');
		$function_type = $request->input('function_type');
		$bill_no = $request->input('bill_no');
		$bill_date = $request->input('bill_date');
		$membership_no = $request->input('membership_no');
		$is_sponsor = $request->input('sponsor');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address = $request->input('address');
		$noofpersons = $request->input('noofpersons');
		$misc = $request->input('misc');
		$misc_amount = $request->input('misc_amount');
		$others = $request->input('others');
		$others_amount = $request->input('others_amount');
		
		$facility = $request->input('facility_id');
		$quantity = $request->input('quantity');
		$noofdays = $request->input('noofdays');
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$booking_rate = $request->input('booking_rate');
		$generator_charges = $request->input('generator_charges');
		$ac_charges = $request->input('ac_charges');
		$safai_general = $request->input('safai_general');
		$security_charges = $request->input('security_charges');
		$rebate_safai = $request->input('rebate_safai');
		$rebate_tentage = $request->input('rebate_tentage');
		$rebate_catering = $request->input('rebate_catering');
		$rebate_electricity = $request->input('rebate_electricity');
		$servicetaxPercentage = $request->input('servicetaxPercentage');
		$servicetaxAmount = $request->input('servicetaxAmount');
		$vatPercentage = $request->input('vatPercentage');
		$vatAmount = $request->input('vatAmount');
		$totalAmount = $request->input('totalAmount');
		
		$this->validate($request,[
			'function_date'=>'required|date',
			'membership_no'=>'required'
		]);
		$result = $this->booking->booking_update($id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount);
		if($result){
			//$request->session()->flash('success', 'Record updated successfully!');
			return redirect()->action(
			    'BookingController@view', ['id' => $id]
			);
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
	public function cancel(Request $request,$id)
    {
		$cancel_date = $request->input('cancel_date');
		$cancel_percentage = $request->input('cancel_percentage');
		$cancel_amount = $request->input('cancel_amount');
		$this->validate($request,[
			'cancel_date'=>'required|date'
		]);
		$result = $this->booking->booking_cancel($id,$cancel_date,$cancel_percentage,$cancel_amount);
		if($result){
			$request->session()->flash('success', 'Booking cancelled successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function delete(Request $request,$id)
    {
		$result = $this->booking->booking_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function addfacility_ajax(Request $request)
    {
		$membertype_id = $request->input('membertype_id');
		$facility_id = $request->input('facility_id');
		$from_date = $request->input('from_date');
		$to_date = $request->input('$to_date');
		$this->booking->addfacility_ajax($membertype_id,$facility_id,$from_date,$to_date);
	}
	public function member_ajax(Request $request)
    {
		$membership_no = $request->input('membership_no');
		$this->booking->member_ajax($membership_no);
	}
}
