<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Auth;

class Receiptcorpusfund extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    
    public function receipt_list()
	{
		return DB::table('receipt')
		->leftJoin('receipt_corpus_fund', 'receipt.id', '=', 'receipt_corpus_fund.parent_id')
		->where([
		['receipt.status','!=','0'],
		['receipt.receipt_type','6'],
		])
		->groupBy('receipt.id')
		->orderBy('receipt_corpus_fund.id', 'desc')
		->get();
	}
	
	public function receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$withtax,$comments)
    {
		$user_id = Auth::id();
		try{
			$receipt_id = DB::transaction(function () use ($user_id,$booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$withtax,$comments) {
			
				if(!empty($function_date)){
					$function_date = date_format(date_create($function_date),"Y-m-d");
				}
				if(!empty($cheque_date)){
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
				}
				
				$receipt_id = DB::table('receipt')->insertGetId(
					    ['receipt_type' => '6','booking_no' => $booking_no,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id, 'comments' => $comments]
				);
					
				DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id]);
				
				DB::table('receipt_corpus_fund') ->insert(
					['parent_id' => $receipt_id, 'corpus_fund' => $corpus_fund]
					);
				
				if($security_deposit>0){
					DB::table('receipt_security') ->insert(
					['parent_id' => $receipt_id, 'security' => $security_deposit]
					);
				}
					
				if($withtax == 1){
					$tax = DB::table('tax')->where('status', 1)->get();
					foreach($tax as $receipt_tax ){
						$tax_name = $receipt_tax->name;
						$tax_percentage = $receipt_tax->percentage;
						DB::table('receipt_tax')->insert(
							['parent_id' => $receipt_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]
						);
					}
				}
				
				return $receipt_id;
			});
			return $receipt_id;
		}
		catch(\Exception $e){
			return FALSE;
		}
    }
}
