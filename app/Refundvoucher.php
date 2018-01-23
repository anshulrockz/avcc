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
			->select('refundvoucher.*','receipt.misc','receipt.misc_amount','receipt.others','receipt.others_amount',DB::raw('SUM(refundvoucherfacility.price*refundvoucherfacility.quantity*refundvoucherfacility.noofdays) as booking_facility_amount'),DB::raw('SUM(refundvoucherfacility.safai) as total_safai'),DB::raw('SUM(refundvoucherfacility.generator) as total_generator'),DB::raw('SUM(refundvoucherfacility.ac) as total_ac'),DB::raw('SUM(refundvoucherfacility.cgst) as total_cgst'),DB::raw('SUM(refundvoucherfacility.sgst) as total_sgst'),DB::raw('SUM(refundvoucherfacility.security*refundvoucherfacility.quantity) as total_security'),DB::raw('SUM(refundvoucherfacility.deduction) as booking_facility_deduction'))
			->where([
			['refundvoucher.id',$id],
			['refundvoucher.status','1'],
			])
            ->leftJoin('refundvoucherfacility', 'refundvoucherfacility.refundvoucher_id', '=', 'refundvoucher.id')
            ->leftJoin('receipt', 'refundvoucher.parent_id', '=', 'receipt.id')
            ->groupBy('refundvoucher.id')
            ->first();

		 return $refundvoucher;
	}
	public function refund_facility($id)
	{
		return DB::table('refundvoucherfacility')
			->select('refundvoucherfacility.*','facility.name as facility_name')
			->where([['refundvoucherfacility.refundvoucher_id',$id]])
            ->leftJoin('facility', 'refundvoucherfacility.facility_id', '=', 'facility.id')
            ->get();
	}
	public function refundvoucher_add($refund_type,$receipt_id,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn)
    {
		$user_id = Auth::id();
		$misc_deduction = 0;
		$others_deduction = 0;
		
		if(!empty($cheque_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		if(!empty($voucher_date)){
			$voucher_date = date_format(date_create($voucher_date),"Y-m-d");
		}
		
		if($refund_type == '1'){
			
			$receipt = DB::table('receipt')
				->where([
				['status','1'],
				//['receipt_status','1'],
				['id',$receipt_id],
				])
	            ->first();
            $receipt_facility = DB::table('receipt')
				->select('receipt_bookingfacility.*')
				->where([
				['receipt.status','1'],
				////['receipt.receipt_status','1'],
				['receipt.id',$receipt_id],
				])
	            ->leftJoin('receipt_bookingfacility', 'receipt_bookingfacility.parent_id', '=', 'receipt.id')
	            ->get();
	            
	        $function_date = $receipt->function_date;
            $misc_amount = $receipt->misc_amount;
            $others_amount = $receipt->others_amount;
	        
	        $cancel_percentage = 5;
			$cancel_date = date_format(date_create($this->date),"Y-m-d");
			$month = Refundvoucher::getMonth($cancel_date,$function_date);
			$diff_in_days = Refundvoucher::getDateDifference($cancel_date,$function_date);
			
            if(!empty($misc_amount)){
				$misc_deduction = $misc_amount*$cancel_percentage*$month/100;
			}
			if(!empty($others_amount)){
				$others_deduction = $others_amount*$cancel_percentage*$month/100;
			}

			$refundvoucher_id = DB::table('refundvoucher')->insertGetId(
				    ['refund_type' => $refund_type,'voucher_date' => $voucher_date,'receipt_id' => $receipt_id,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'misc_deduction' => $misc_deduction,'others_deduction' => $others_deduction,'created_at' => $this->date,'created_by' => $user_id]
			);
			
			foreach($receipt_facility as $value){
				$facility_id = $value->facility_id;
				$price = $value->booking_rate;
				$quantity = $value->quantity;
				$noofdays = $value->noofdays;
				$safai = $value->safai_general;
				$generator = $value->generator_charges;
				$ac = $value->ac_charges;
				$cgst = $value->servicetax_percentage;
				$sgst = $value->vat_percentage;
				$security = $value->security_charges;
				$deduction = Refundvoucher::getFacilityCancelAmount($facility_id,$cancel_percentage,$month,$diff_in_days);
				DB::table('refundvoucherfacility')->insert(
					    ['refundvoucher_id' => $refundvoucher_id,'facility_id' => $facility_id,'price' => $price,'quantity' => $quantity,'noofdays' => $noofdays,'safai' => $safai,'generator' => $generator,'ac' => $ac,'cgst' => $cgst,'sgst' => $sgst,'deduction' => $deduction]);
				}
		}

		if($refund_type == '2'){
			$receipt = DB::table('receipt')
				->where([
				['receipt.status','1'],
				////['receipt.receipt_status','1'],
				['receipt.id',$receipt_id]
				])
				->first();
				
			if($receipt->receipt_type == '1'){
				$receipt = DB::table('receipt')
					->select(DB::raw('SUM(receipt_bookingfacility.security_total) as security_deposit'))
					->leftJoin('receipt_bookingfacility','receipt_bookingfacility.parent_id','receipt.id')
					->where([
					['receipt.status','1'],
					//['receipt.receipt_status','1'],
					['receipt.id',$receipt_id]
					])
					->first();
			}
			else{
				$receipt = DB::table('receipt')
					->where([
					['receipt.status','1'],
					//['receipt.receipt_status','1'],
					['receipt.id',$receipt_id]
					])
					->first();
			}
			
			$security_refund = $receipt->security_deposit;
			$refundvoucher_id = DB::table('refundvoucher')->insert(
				    ['refund_type' => $refund_type,'security_refund' => $security_refund,'voucher_date' => $voucher_date,'receipt_id' => $receipt_id,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'misc_deduction' => $misc_deduction,'others_deduction' => $others_deduction,'created_at' => $this->date,'created_by' => $user_id]
			);
		}
		
		return $refundvoucher_id;
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
	public function receipt($token)
	{
		return DB::table('receipt')
		->select('receipt_booking.misc_amount','receipt_booking.others_amount','receipt.*')
		->where([
		['receipt.id',$token],
		['receipt.status','1']
		])
        ->leftJoin('receipt_booking', 'receipt_booking.parent_id', '=', 'receipt.id')
        ->first();
	}
	public function receiptfacility($token)
	{
		return DB::table('receipt')
		->select('receipt_bookingfacility.*','facility.name as facility_name')
		->where([
		['receipt.id',$token],
		['receipt.status','1']
		])
        ->leftJoin('receipt_bookingfacility', 'receipt_bookingfacility.parent_id', '=', 'receipt.id')
         ->leftJoin('facility', 'receipt_bookingfacility.facility_id', '=', 'facility.id')
        ->get();
	}
	public function partial_update($receipt_id,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$facility_arr,$booking_rate,$quantity,$no_of_days,$amount,$deduction_arr,$misc_deduction,$others_deduction)
    {
		$user_id = Auth::id();
		$misc_deduction = 0;
		$others_deduction = 0;
		
		if(!empty($voucher_date)){
			$voucher_date = date_format(date_create($voucher_date),"Y-m-d");
		}
		if(!empty($voucher_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		
		DB::transaction(function () use ($user_id,$receipt_id,$voucher_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$facility_arr,$booking_rate,$quantity,$no_of_days,$amount,$deduction_arr,$misc_deduction,$others_deduction) {
		
		$refundvoucher_id = DB::table('refundvoucher')->insertGetId(
			    ['voucher_date' => $voucher_date,'refund_type' => '3','receipt_id' => $receipt_id,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'misc_deduction' => $misc_deduction,'others_deduction' => $others_deduction,'created_at' => $this->date,'created_by' => $user_id]
		);

		$facility = DB::table('receipt')
			->select('receipt_bookingfacility.facility_id','receipt_bookingfacility.booking_rate','receipt_bookingfacility.quantity','receipt_bookingfacility.noofdays','receipt_bookingfacility.safai_general','receipt_bookingfacility.generator_charges','receipt_bookingfacility.ac_charges','receipt_bookingfacility.servicetax_percentage','receipt_bookingfacility.vat_percentage','receipt_bookingfacility.security_charges')
			->where([
			['receipt.id',$receipt_id],
			])
            ->leftJoin('receipt_bookingfacility', 'receipt_bookingfacility.parent_id', '=', 'receipt.id')
            ->get();
            
        $i=0; 
        foreach($facility as $key=>$value){
			$facility[$key]->deduction = $deduction_arr[$i];
			$i++;
			$facility_id = $value->facility_id;
			$price = $value->booking_rate;
			$quantity = $value->quantity;
			$noofdays = $value->noofdays;
			$safai = $value->safai_general;
			$generator = $value->generator_charges;
			$ac = $value->ac_charges;
			$cgst = $value->servicetax_percentage;
			$sgst = $value->vat_percentage;
			$security = $value->security_charges;
			$deduction = $value->deduction;
			
			DB::table('refundvoucherfacility')->insert(
			    ['refundvoucher_id' => $refundvoucher_id,'facility_id' => $facility_id,'price' => $price,'quantity' => $quantity,'noofdays' => $noofdays,'safai' => $safai,'generator' => $generator,'ac' => $ac,'cgst' => $cgst,'sgst' => $sgst,'deduction' => $deduction]);
		}
            	
		return $refundvoucher_id;
		
		});
    }

	public function getReceiptID($voucher_id)
	{
		$refundvoucher = DB::table('refundvoucher')
			->select('receipt_id')
			->where([
			['id',$voucher_id],
			])
            ->first();
        return $refundvoucher->receipt_id;
	}
}