<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receiptothers extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function receipt_list()
	{
		return DB::table('receipt')
		->where([
		['status','1'],
		['receipt_type','4'],
		])
		->orderBy('id', 'desc')
		->get();
	}
    public function receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$others,$others_withtax,$comments)
    {
		$user_id = Auth::id();
		if(empty($others_withtax)){
			$others_withtax = 0;
		}
		if(!empty($function_date)){
			$function_date = date_format(date_create($function_date),"Y-m-d");
		}
		if(!empty($function_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		
		if($booking_no !=''){
			$data = DB::table('booking')
                ->where([
			    ['status', '1'],
			    ['booking_no', $booking_no]])
                ->get();
			foreach ($data as $value){
				$booking_id = $value->id;
				$booking_date = $value->booking_date;
				$party_name = $value->party_name;
				$party_gstin = $value->party_gstin;
				$reverse_charges = $value->reverse_charges;
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
			}
			$receipt_id = DB::table('receipt')->insertGetId(
			    ['booking_id' => $booking_id,'receipt_type' => '4','booking_no' => $booking_no,'booking_date' => $booking_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'security_deposit' => $security_deposit,'corpus_fund' => $corpus_fund,'others_amount' => $others,'others_withtax' => $others_withtax,'comments' => $comments,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,'created_at' => $this->date,'created_by' => $user_id]
			);
		}
		else{
			$receipt_id = DB::table('receipt')->insertGetId(
			    ['receipt_type' => '4','party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'security_deposit' => $security_deposit,'corpus_fund' => $corpus_fund,'others_amount' => $others,'others_withtax' => $others_withtax,'comments' => $comments,'created_at' => $this->date,'created_by' => $user_id]
			);
		}
		return $receipt_id;
    }
}
