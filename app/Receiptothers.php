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
		return DB::table('receipt_others')
		->select('receipt_others.*','receipt_security.*','receipt_corpus_fund.*','receipt_tax.*', 'receipt.*')
		->leftJoin('receipt', 'receipt.id', '=', 'receipt_others.parent_id')
		->leftJoin('receipt_security', 'receipt_security.id', '=', 'receipt_others.parent_id')
		->leftJoin('receipt_corpus_fund', 'receipt_corpus_fund.parent_id', '=', 'receipt_others.parent_id')
		->leftJoin('receipt_tax', 'receipt_tax.parent_id', '=', 'receipt_others.parent_id')
		->where([
		['receipt.status','1'],
		])
		->groupBy('receipt.id')
		->orderBy('receipt.id', 'desc')
		->get();
	}
    public function receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$others,$withtax,$comments)
    {
		$user_id = Auth::id();
		try{
			$receipt_id = DB::transaction(function () use ($user_id,$booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$security_deposit,$corpus_fund,$others,$withtax,$comments) {
			
				if(empty($others_withtax)){
					$others_withtax = 0;
				}
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
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['booking_no' => $booking_id,'receipt_type' => '10','payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id]
					);
					
					DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id]);
					
					$receipt_security_id = DB::table('receipt_security') ->insertGetId(
					['parent_id' => $receipt_id, 'security' => $security_deposit, 'comments' => $comments]
					);
					
					$security_deposit_id = DB::table('receipt_others') ->insertGetId(['parent_id' => $receipt_id, 'misc' => $others, 'comments' => $comments]
					);
					
					$receipt_corpus_fund_id = DB::table('receipt_corpus_fund') ->insertGetId(
					['parent_id' => $receipt_id, 'corpus_fund' => $corpus_fund, 'comments' => $comments]
					);
					
					if(!empty($withtax)){
						$tax = DB::table('tax')->where('status', 1)->get();
						foreach($tax as $receipt_tax ){
							$tax_name = $receipt_tax->name;
							$tax_percentage = $receipt_tax->percentage;
							$receipt_tax_id = DB::table('receipt_tax')->insertGetId(['parent_id' => $receipt_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]);
						}
					}
					
					//'corpus_fund' => $corpus_fund,'others_amount' => $others,'others_withtax' => $others_withtax,'comments' => $comments,'bill_no' => $bill_no,'bill_date' => $bill_date,'noofpersons' => $noofpersons,'cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,
				}
				else{
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['booking_no' => $booking_no,'receipt_type' => '10','booking_no' => $booking_no,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id]
					);
					
					DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id]);
					
					$security_deposit_id = DB::table('receipt_security') ->insertGetId(
					['parent_id' => $receipt_id, 'security' => $security_deposit, 'comments' => $comments]
					);
					
					$security_deposit_id = DB::table('receipt_others') ->insertGetId(
					['parent_id' => $receipt_id, 'misc' => $others, 'comments' => $comments]
					);
					
					$security_deposit_id = DB::table('receipt_corpus_fund') ->insertGetId(
					['parent_id' => $receipt_id, 'corpus_fund' => $corpus_fund, 'comments' => $comments]
					);
					
					if(!empty($withtax)){
						$tax = DB::table('tax')->where('status', 1)->get();
						foreach($tax as $receipt_tax ){
							$tax_name = $receipt_tax->name;
							$tax_percentage = $receipt_tax->percentage;
							$receipt_tax_id = DB::table('receipt_tax')->insertGetId(
							['parent_id' => $receipt_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]
							);
						}
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
