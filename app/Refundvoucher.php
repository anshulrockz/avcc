<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;
use App\Booking;

class Refundvoucher extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
		$this->booking = new Booking();
    }
    public function refundvoucher_list()
	{
		$refundvoucher = DB::table('refundvoucher')
			->where([
			['status','1'],
			])
			->orderBy('id','desc')
            ->get();

		return $refundvoucher;
	}
	public function refundvoucher_view($id)
	{
        $refundvoucher = DB::table('refundvoucher')
			->select('refundvoucher.*','booking.booking_no','booking.membership_no','booking.function_date')
			->where([
			['refundvoucher.id',$id],
			['refundvoucher.status','1'],
			])
			->leftJoin('booking', 'booking.id', '=', 'refundvoucher.booking_id')
            ->first();

//        echo "<pre>";
//        print_r($refundvoucher);
//        die;

		 return $refundvoucher;
	}
	public function refund_facility($id)
	{
		return DB::table('refundvoucherfacility')
			->select('refundvoucherfacility.*','facility.name as facility_name')
			->where([['refundvoucherfacility.refundvoucher_id',$id],['refundvoucherfacility.status','1']])
            ->leftJoin('facility', 'refundvoucherfacility.facility_id', '=', 'facility.id')
            ->get();
	}
	public function refundvoucher_add($refund_type,$receipt_no,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn)
    {
		$user_id = Auth::id();
		if(!empty($cheque_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		$voucher_date = date_format(date_create($voucher_date),"Y-m-d");
		
		$booking_no = '';
		if(!empty($receipt_no)){
			$receipt = DB::table('receipt')
			->select('booking_no','booking_id')
			->where([
			['id',$receipt_no]
			])
			->first();
			$booking_no = $receipt->booking_no;
			$booking_id = $receipt->booking_id;
		}
		
		$bookingdetails = Refundvoucher::bookingdetails($booking_no,$refund_type);
		foreach($bookingdetails as $value){
			$sub_total = $value->sub_total;
			$misc_amount = $value->misc_amount;
			$others_amount = $value->others_amount;
			$cancel_amount = $value->cancel_amount;
			$with_tax = $value->with_tax;
			$with_security = $value->with_security;
			$security_total = $value->security_total;
			$service_tax = $value->service_tax;
			$vat = $value->vat;
			$membership_no = $value->membership_no;
		}
		
		$global_st = $this->booking->global_st();
		$global_vat = $this->booking->global_vat();
		$others_st = $others_amount*$global_st/100;
		$others_vat = $others_amount*$global_vat/100;
		
		$tax = 0;
		$security = 0;
		$refunded_amount = 0;
		$total_amount = 0;
		
		if($with_tax == '1'){
			$tax = $service_tax+$vat+$others_st+$others_vat;
		}
		if($with_security == '1'){
			$security = $security_total;
		}
		if($refund_type == '1'){
			$refunded_amount = $tax+$sub_total+$misc_amount+$others_amount+$security-$cancel_amount;
			$total_amount = $sub_total+$misc_amount+$others_amount+$security;
		}
		if($refund_type == '2'){
			$refunded_amount = $security;
			$cancel_amount = 0;
			$total_amount = $security;
		}
		
		$voucher_id = DB::table('refundvoucher')->insertGetId(
			    ['refund_type' => $refund_type,'amount' => $total_amount,'deduction' => $cancel_amount,'security' => $security,'booking_id' => $booking_id,'receipt_id' => $receipt_no,'voucher_date' => $voucher_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'created_at' => $this->date,'created_by' => $user_id]
		);
		return $voucher_id;
    }

	public function partial_insert_booking($id,$remaining_facility,$booking){
		$user_id = Auth::id();
		foreach($booking as $value){
			$booking_no = $value->booking_no;
			$booking_date = $value->booking_date;
			$party_name = $value->party_name;
			$function_date = $value->function_date;
			$from_time = $value->from_time;
			$to_time = $value->to_time;
			$function_type = $value->function_type;
			$bill_no = $value->bill_no;
			$bill_date = $value->bill_date;
			$membership_no = $value->membership_no;
			$is_sponsor = $value->is_sponsor;
			$phone = $value->phone;
			$mobile = $value->mobile;
			$address = $value->address;
			$noofpersons = $value->noofpersons;
			$with_tax = $value->with_tax;
			$with_security = $value->with_security;
			$misc = $value->misc;
			$misc_amount = $value->misc_amount;
			$others = $value->others;
			$others_amount = $value->others_amount;
		}
		
		$booking_update = DB::table('booking')
	    ->where('id', $id)
	    ->update(['booking_status' => '3','updated_at' => $this->date,'updated_by' => $user_id]);
	    
		$booking_id = DB::table('booking')->insertGetId(
		    ['booking_no' => $booking_no,'booking_date' => $booking_date,'party_name' => $party_name,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'booking_status' => '1','with_tax' => $with_tax,'with_security' => $with_security,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
		);
	    
	    for($i=0;$i<count($remaining_facility);$i++){
			$facility_id = $remaining_facility[$i];
			$booking_facility = DB::table('bookingfacility')->where('id',$facility_id)->get();
			foreach($booking_facility as $value){
				$facility_id = $value->facility_id;
				$quantity = $value->quantity;
				$noofdays = $value->noofdays;
				$from_date = $value->from_date;
				$to_date = $value->to_date;
				$booking_rate = $value->booking_rate;
				$safai_general = $value->safai_general;
				$safai_total = $value->safai_total;
				$generator_charges = $value->generator_charges;
				$generator_total = $value->generator_total;
				$ac_charges = $value->ac_charges;
				$ac_total = $value->ac_total;
				$security_charges = $value->security_charges;
				$security_total = $value->security_total;
				$rebate_safai = $value->rebate_safai;
				$rebate_tentage = $value->rebate_tentage;
				$rebate_catering = $value->rebate_catering;
				$rebate_electricity = $value->rebate_electricity;
				$servicetax_percentage = $value->servicetax_percentage;
				$servicetax_amount = $value->servicetax_amount;
				$servicetax_total = $value->servicetax_total;
				$vat_percentage = $value->vat_percentage;
				$vat_amount = $value->vat_amount;
				$vat_total = $value->vat_total;
				$total_amount = $value->total_amount;
			}
			DB::table('bookingfacility')->insert(
				['booking_id' => $booking_id,'facility_id' => $facility_id,'quantity' => $quantity,'noofdays' => $noofdays,'from_date' => $from_date,'to_date' => $to_date,'booking_rate' => $booking_rate,'generator_charges' => $generator_charges,'generator_total' => $generator_total,'ac_charges' => $ac_charges,'ac_total' => $ac_total,'safai_general' => $safai_general,'safai_total' => $safai_total,'security_charges' => $security_charges,'security_total' => $security_total,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_electricity' => $rebate_electricity,'servicetax_percentage' => $servicetax_percentage,'servicetax_amount' => $servicetax_amount,'servicetax_total' => $servicetax_total,'vat_percentage' => $vat_percentage,'vat_amount' => $vat_amount,'vat_total' => $vat_total,'total_amount' => $total_amount,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
			);
		}
		return $booking_id;
	}

	public function partial_insert_receipt($id,$remaining_facility,$newbooking_id,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn){
		$user_id = Auth::id();
		$booking = DB::table('booking')->where('id',$newbooking_id)->get();
		foreach($booking as $value){
			$booking_no = $value->booking_no;
			$booking_date = $value->booking_date;
			$party_name = $value->party_name;
			$function_date = $value->function_date;
			$from_time = $value->from_time;
			$to_time = $value->to_time;
			$function_type = $value->function_type;
			$bill_no = $value->bill_no;
			$bill_date = $value->bill_date;
			$membership_no = $value->membership_no;
			$is_sponsor = $value->is_sponsor;
			$phone = $value->phone;
			$mobile = $value->mobile;
			$address = $value->address;
			$noofpersons = $value->noofpersons;
			$with_tax = $value->with_tax;
			$with_security = $value->with_security;
			$misc = $value->misc;
			$misc_amount = $value->misc_amount;
			$others = $value->others;
			$others_amount = $value->others_amount;
		}
	    
	    $receipt_update = DB::table('receipt')
	    ->where('booking_id', $id)
	    ->update(['receipt_status' => '2','updated_at' => $this->date,'updated_by' => $user_id]);
		
		$receipt_id = DB::table('receipt')->insertGetId(
			['booking_id' => $newbooking_id,'receipt_type' => '1','booking_no' => $booking_no,'booking_date' => $booking_date,'party_name' => $party_name,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'noofpersons' => $noofpersons,'with_tax' => $with_tax,'with_security' => $with_security,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
		);
	    
	    for($i=0;$i<count($remaining_facility);$i++){
			$facility_id = $remaining_facility[$i];
			$booking_facility = DB::table('bookingfacility')->where('id',$facility_id)->get();
			foreach($booking_facility as $value){
				$facility_id = $value->facility_id;
				$quantity = $value->quantity;
				$noofdays = $value->noofdays;
				$from_date = $value->from_date;
				$to_date = $value->to_date;
				$booking_rate = $value->booking_rate;
				$safai_general = $value->safai_general;
				$safai_total = $value->safai_total;
				$generator_charges = $value->generator_charges;
				$generator_total = $value->generator_total;
				$ac_charges = $value->ac_charges;
				$ac_total = $value->ac_total;
				$security_charges = $value->security_charges;
				$security_total = $value->security_total;
				$rebate_safai = $value->rebate_safai;
				$rebate_tentage = $value->rebate_tentage;
				$rebate_catering = $value->rebate_catering;
				$rebate_electricity = $value->rebate_electricity;
				$servicetax_percentage = $value->servicetax_percentage;
				$servicetax_amount = $value->servicetax_amount;
				$servicetax_total = $value->servicetax_total;
				$vat_percentage = $value->vat_percentage;
				$vat_amount = $value->vat_amount;
				$vat_total = $value->vat_total;
				$total_amount = $value->total_amount;
			}
			DB::table('receiptfacility')->insert(
				['receipt_id' => $receipt_id,'booking_id' => $newbooking_id,'facility_id' => $facility_id,'quantity' => $quantity,'noofdays' => $noofdays,'from_date' => $from_date,'to_date' => $to_date,'booking_rate' => $booking_rate,'generator_charges' => $generator_charges,'generator_total' => $generator_total,'ac_charges' => $ac_charges,'ac_total' => $ac_total,'safai_general' => $safai_general,'safai_total' => $safai_total,'security_charges' => $security_charges,'security_total' => $security_total,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_electricity' => $rebate_electricity,'servicetax_percentage' => $servicetax_percentage,'servicetax_amount' => $servicetax_amount,'servicetax_total' => $servicetax_total,'vat_percentage' => $vat_percentage,'vat_amount' => $vat_amount,'vat_total' => $vat_total,'total_amount' => $total_amount,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
			);
		}
		return $receipt_id;
	}

	public function refundvoucher_update($receipt_id,$booking_id,$facility_checked,$facility_hidden,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn)
    {
		$user_id = Auth::id();
		
		$remaining_facility = array_values(array_diff($facility_hidden,$facility_checked));
		
		DB::transaction(function () use ($user_id,$receipt_id,$booking_id,$facility_checked,$facility_hidden,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$remaining_facility) {
		
		$booking = DB::table('booking')->where('id',$booking_id)->get();
		foreach($booking as $value){
			$function_date = $value->function_date;
		}
		
		$newbooking_id = Refundvoucher::partial_insert_booking($booking_id,$remaining_facility,$booking);
		
		$newreceipt_id = Refundvoucher::partial_insert_receipt($booking_id,$remaining_facility,$newbooking_id,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn);
		
		$cancel_date = date_format(date_create($this->date),"Y-m-d");
		$month = Refundvoucher::getMonth($cancel_date,$function_date);
		$diff_in_days = Refundvoucher::getDateDifference($cancel_date,$function_date);
		$cancel_percentage = 5;
		$cancel_amount = 0;
		$amount = 0;
		$security = 0;
		
		for($i=0;$i<count($facility_checked);$i++){
			$bookingfacility_id = $facility_checked[$i];
			$cancel_amount += Refundvoucher::getFacilityCancelAmount($bookingfacility_id,$cancel_percentage,$month,$diff_in_days);
			$refund_facility = Refundvoucher::refundFacilityDetails($bookingfacility_id);
			$amount += $refund_facility->total_amount;
			$security += $refund_facility->security_total;
		}
		
		$refundvoucher_id = DB::table('refundvoucher')->insertGetId(
			    ['refund_type' => '3','amount' => $amount,'deduction' => $cancel_amount,'security' => $security,'receipt_id' => $receipt_id,'booking_id' => $booking_id,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'voucher_date' => $this->date,'created_at' => $this->date,'created_by' => $user_id]
		);
		
		for($i=0;$i<count($facility_checked);$i++){
			$facility_id = $facility_checked[$i];
			$booking_facility = DB::table('bookingfacility')->where('id',$facility_id)->get();
			foreach($booking_facility as $value){
				$facility_id = $value->facility_id;
				$quantity = $value->quantity;
				$noofdays = $value->noofdays;
				$from_date = $value->from_date;
				$to_date = $value->to_date;
				$booking_rate = $value->booking_rate;
				$safai_general = $value->safai_general;
				$safai_total = $value->safai_total;
				$generator_charges = $value->generator_charges;
				$generator_total = $value->generator_total;
				$ac_charges = $value->ac_charges;
				$ac_total = $value->ac_total;
				$security_charges = $value->security_charges;
				$security_total = $value->security_total;
				$rebate_safai = $value->rebate_safai;
				$rebate_tentage = $value->rebate_tentage;
				$rebate_catering = $value->rebate_catering;
				$rebate_electricity = $value->rebate_electricity;
				$servicetax_percentage = $value->servicetax_percentage;
				$servicetax_amount = $value->servicetax_amount;
				$servicetax_total = $value->servicetax_total;
				$vat_percentage = $value->vat_percentage;
				$vat_amount = $value->vat_amount;
				$vat_total = $value->vat_total;
				$total_amount = $value->total_amount;
			}
			DB::table('refundvoucherfacility')->insert(
				['refundvoucher_id' => $refundvoucher_id,'facility_id' => $facility_id,'quantity' => $quantity,'noofdays' => $noofdays,'from_date' => $from_date,'to_date' => $to_date,'booking_rate' => $booking_rate,'generator_charges' => $generator_charges,'generator_total' => $generator_total,'ac_charges' => $ac_charges,'ac_total' => $ac_total,'safai_general' => $safai_general,'safai_total' => $safai_total,'security_charges' => $security_charges,'security_total' => $security_total,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_electricity' => $rebate_electricity,'servicetax_percentage' => $servicetax_percentage,'servicetax_amount' => $servicetax_amount,'servicetax_total' => $servicetax_total,'vat_percentage' => $vat_percentage,'vat_amount' => $vat_amount,'vat_total' => $vat_total,'total_amount' => $total_amount,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
			);
		}
		
		return $refundvoucher_id;
		
		});
    }
	function getFacilityCancelAmount($bookingfacility_id,$cancel_percentage,$month,$diff_in_days){
		
		$bookingfacility = DB::table('bookingfacility')
			->select('facility_id','booking_rate','quantity','noofdays')
			->where([
			['id',$bookingfacility_id],
			['status','1'],
			])
            ->get();
        foreach($bookingfacility as $value){
			$facility_id = $value->facility_id;
			$booking_rate = $value->booking_rate;
			$quantity = $value->quantity;
			$noofdays = $value->noofdays;
			$booking_amount = $booking_rate*$quantity*$noofdays;
			if($facility_id == '1'){
				if($diff_in_days > 3){
					$cancel_percentage = 50;
				}
				else{
					$cancel_percentage = 75;
				}
				$cancellation_amount = $booking_amount*$cancel_percentage/100;
			}
			else{
				$cancellation_amount = $booking_amount*$cancel_percentage*$month/100;
			}
		}
		return $cancellation_amount;
	}
	function getMonth($cancel_date,$function_date){
		$cancel_date = Carbon::createFromFormat('Y-m-d', $cancel_date);
		$function_date = Carbon::createFromFormat('Y-m-d', $function_date);
		$year1 = $cancel_date->year;
		$year2 = $function_date->year;
		$month1 = $cancel_date->month;
		$month2 = $function_date->month;
		$year = $year2-$year1;
		$month = $year*12+$month2-$month1+1;
		return $month;
	}
	function getDateDifference($cancel_date,$function_date){
		$cancel_date = Carbon::createFromFormat('Y-m-d', $cancel_date);
		$function_date = Carbon::createFromFormat('Y-m-d', $function_date);
		return $function_date->diffInDays($cancel_date);
	}
	public function bookingdetails($booking_no,$refund_type)
	{
		if($refund_type == '1'){
			$booking_details = DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as sub_total'),DB::raw('SUM(security_total) as security_total'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'))
			->where([
			['booking_no',$booking_no],
			['booking_status','2'],
			['booking.status','1']
			])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->get();
		}
		else{
			$booking_details = DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as sub_total'),DB::raw('SUM(security_total) as security_total'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'))
			->where([
			['booking_no',$booking_no],
			['booking.status','1']
			])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->get();
		}
		return $booking_details;
	}
	public function bookingfacility($receipt_no)
	{
		$booking_no = '';
		if(!empty($receipt_no)){
			$receipt = DB::table('receipt')
			->select('booking_no')
			->where([
			['id',$receipt_no]
			])
			->first();
			$booking_no = $receipt->booking_no;
		}
		return DB::table('bookingfacility')
		->select('bookingfacility.*','booking.booking_no','facility.name as facility_name')
		->where([
		['booking.booking_no',$booking_no],
		['booking.booking_status','1'],
		['booking.status','1']
		])
        ->leftJoin('booking', 'bookingfacility.booking_id', '=', 'booking.id')
         ->leftJoin('facility', 'bookingfacility.facility_id', '=', 'facility.id')
        ->get();
	}
	public function booking($receipt_no)
	{
		$booking_no = '';
		if(!empty($receipt_no)){
			$receipt = DB::table('receipt')
			->select('booking_no')
			->where([
			['id',$receipt_no]
			])
			->first();
			$booking_no = $receipt->booking_no;
		}
		return DB::table('booking')
			->select('booking.*','member.name as member_name','membertype.name as member_type','membertype.id as membertype_id','member.membership_no')
			->where([
			['booking.booking_no',$booking_no],
			['booking.booking_status','1'],
			['booking.status','1']
			])
            ->leftJoin('member', 'member.membership_no', '=', 'booking.membership_no')
            ->leftJoin('membertype', 'membertype.id', '=', 'member.member_type')
            ->get();
	}
	public function bookingdetails_ajax($receipt_no,$refund_type)
	{
		$booking_no = '';
		if(!empty($receipt_no)){
			$receipt = DB::table('receipt')
			->select('booking_no')
			->where([
			['id',$receipt_no]
			])
			->first();
			$booking_no = $receipt->booking_no;
		}
		if($refund_type == '1'){
			$booking_details = DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as sub_total'),DB::raw('SUM(security_total) as security_total'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'))
			->where([
			['booking_no',$booking_no],
			['booking_status','2'],
			['booking.status','1']
			])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->get();
		}
		else{
			$booking_details = DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as sub_total'),DB::raw('SUM(security_total) as security_total'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'))
			->where([
			['booking_no',$booking_no],
			['booking_status','1'],
			['booking.status','1']
			])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->get();
		}
		print_r(json_encode( array($booking_details)));
	}
	function getPartialFacilityCancelAmount($bookingfacility_id,$cancel_percentage,$month,$diff_in_days){
		
		$bookingfacility = DB::table('refundvoucherfacility')
			->select('facility_id','booking_rate','quantity','noofdays')
			->where([
			['id',$bookingfacility_id],
			['status','1'],
			])
            ->get();
        foreach($bookingfacility as $value){
			$facility_id = $value->facility_id;
			$booking_rate = $value->booking_rate;
			$quantity = $value->quantity;
			$noofdays = $value->noofdays;
			$booking_amount = $booking_rate*$quantity*$noofdays;
			if($facility_id == '1'){
				if($diff_in_days > 3){
					$cancel_percentage = 50;
				}
				else{
					$cancel_percentage = 75;
				}
				$cancellation_amount = $booking_amount*$cancel_percentage/100;
			}
			else{
				$cancellation_amount = $booking_amount*$cancel_percentage*$month/100;
			}
		}
		return $cancellation_amount;
	}
	public function refundFacilityDetails($facility_id)
	{
		return DB::table('bookingfacility')
			->where([
			['id',$facility_id],
			])
            ->first();
	}
}
