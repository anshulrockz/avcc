<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Stl extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function stl_list()
	{
		return DB::table('booking')
			->where([
			['with_tax','0'],
			['booking_status','1'],
			['status','1']])
			->get();
	}
	public function receipt_create($id,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn)
    {
		$user_id = Auth::id();
		try{
			$transaction = DB::transaction(function () use ($user_id,$id,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn){
				DB::table('booking')
	            ->where('id', $id)
	            ->update(['with_tax' => '1','updated_at' => $this->date,'updated_by' => $user_id]);
	            $receipt = DB::table('receipt')
	                ->where([
				    ['status', '1'],
				    ['booking_id', $id],
				    ['receipt_type', '1'],
				    ['receipt_status', '1']
				    ])
	                ->get();
		        foreach ($receipt as $value){
					$receipt_id = $value->id;
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
					$phone = $value->phone;
					$mobile = $value->mobile;
					$address = $value->address;
					$noofpersons = $value->noofpersons;
					$cancel_date = $value->cancel_date;
					$cancel_percentage = $value->cancel_percentage;
					$cancel_amount = $value->cancel_amount;
					$misc = $value->misc;
					$misc_amount = $value->misc_amount;
				}
				$newreceipt_id = DB::table('receipt')->insertGetId(
				    ['booking_id' => $id,'receipt_type' => '2','booking_no' => $booking_no,'booking_date' => $booking_date,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'party_name' => $party_name,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'noofpersons' => $noofpersons,'cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,'with_tax' => '1','misc' => $misc,'misc_amount' => $misc_amount,'created_at' => $this->date,'created_by' => $user_id]
				);
				$receiptfacility = DB::table('receiptfacility')
	                ->where([
				    ['status', '1'],
				    ['receipt_id', $receipt_id]
				    ])
	                ->get();
	            foreach ($receiptfacility as $value){
					$booking_id = $value->booking_id;
					$facility_id = $value->facility_id;
					$quantity = $value->quantity;
					$noofdays = $value->noofdays;
					$from_date = $value->from_date;
					$to_date = $value->to_date;
					$booking_rate = $value->booking_rate;
					$generator_charges = $value->generator_charges;
					$generator_total = $generator_charges*$quantity*$noofdays;
					$ac_charges = $value->ac_charges;
					$ac_total = $ac_charges*$quantity*$noofdays;
					$safai_general = $value->safai_general;
					$safai_total = $safai_general*$quantity*$noofdays;
					$security_charges = $value->security_charges;
					$security_total = $security_charges*$quantity;
					$rebate_safai = $value->rebate_safai;
					$rebate_tentage = $value->rebate_tentage;
					$rebate_catering = $value->rebate_catering;
					$rebate_electricity = $value->rebate_electricity;
					$servicetax_percentage = $value->servicetax_percentage;
					$servicetax_amount = $value->servicetax_amount;
					$servicetax_total = $servicetax_amount*$quantity*$noofdays;
					$vat_percentage = $value->vat_percentage;
					$vat_amount = $value->vat_amount;
					$vat_total = $vat_amount*$quantity*$noofdays;
					$total_amount = $value->total_amount;
					DB::table('receiptfacility')->insert(
						['receipt_id' => $newreceipt_id,'booking_id' => $booking_id,'facility_id' => $facility_id,'quantity' => $quantity,'noofdays' => $noofdays,'from_date' => $from_date,'to_date' => $to_date,'booking_rate' => $booking_rate,'generator_charges' => $generator_charges,'generator_total' => $generator_total,'ac_charges' => $ac_charges,'ac_total' => $ac_total,'safai_general' => $safai_general,'safai_total' => $safai_total,'security_charges' => $security_charges,'security_total' => $security_total,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_electricity' => $rebate_electricity,'servicetax_percentage' => $servicetax_percentage,'servicetax_amount' => $servicetax_amount,'servicetax_total' => $servicetax_total,'vat_percentage' => $vat_percentage,'vat_amount' => $vat_amount,'vat_total' => $vat_total,'total_amount' => $total_amount,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
					);
				}
				return $newreceipt_id;
			});
			return $transaction;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
    }
	public function stl_view($id)
	{
		return DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'))
			->where('booking.id',$id)
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->get();
	}
}
