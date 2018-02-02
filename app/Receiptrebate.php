<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receiptrebate extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    
    public function receipt_list()
	{
		return DB::table('receipt_rebate')
		->leftJoin('receipt','receipt_rebate.parent_id', '=','receipt.id')
		->where([
		['receipt.status','!=','0'],
		['receipt.receipt_type','8'],
		])
		->orderBy('receipt_rebate.id','DESC')
		->get();
	}
	
	public function receipt_view($id)
	{
		return DB::table('receipt')
		->select('receipt_rebate.rebate_no','receipt_rebate.receipt_id','receipt_rebate.safai','receipt_rebate.tentage','receipt_rebate.catering','receipt_rebate.food','receipt_rebate.electricity','receipt_rebate.tax1','receipt_rebate.tax2','receipt_rebate.with_tax','receipt_rebate.comments')
		->where([
			['receipt.id',$id],
			])
		->leftJoin('receipt_rebate','receipt_rebate.parent_id','receipt.id')
		->groupBy('receipt.id')
		->first();
	}
	
    public function receipt_add($receipt_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$safai,$tentage,$catering,$electricity,$comments)
    {
		$receipt_id = DB::transaction(function () use($receipt_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$safai,$tentage,$catering,$electricity,$comments) {
			
			$receipt = DB::table('receipt')
                ->where([
					    ['status', '1'],
					    ['id', $receipt_no]
					    ])
                ->first();
                
			$parent_id = $receipt->id;
			$booking_no = $receipt->booking_no;
			$party_name = $receipt->party_name;
			$party_gstin = $receipt->party_gstin;
			$reverse_charges = $receipt->reverse_charges;
			$phone = $receipt->phone;
			$mobile = $receipt->mobile;
			$address = $receipt->address;
			$membership_no = $receipt->membership_no;
			$function_date = $receipt->function_date;
			
			$contractor = DB::table('receipt')
				->select('receipt_tentage.contractor_id')
				->leftJoin('receipt_tentage','receipt_tentage.parent_id','receipt.id')
                ->where([
					    ['receipt.status', '1'],
					    ['receipt.booking_no', $booking_no]
					    ])
                ->first();
            if(count($contractor)>0)    
            if(!empty($contractor->contractor_id))
			$contractor_id = $contractor->contractor_id;
	
			else $contractor_id = 0;
			
			$user_id = Auth::id();
			
			if(!empty($cheque_date)){
				$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
			}
			
			$receipt_id = DB::table('receipt')->insertGetId(
			    ['receipt_type' => '8','booking_no' => $booking_no,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'address' => $address,'membership_no' => $membership_no,'function_date' => $function_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id, 'comments' => $comments]
			);
			
			DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id,]);
				
			DB::table('receipt_rebate')->insertGetId(
			    ['parent_id' => $receipt_id,'contractor_id' => $contractor_id,'safai' => $safai,'tentage' => $tentage,'catering' => $catering,'electricity' => $electricity]
			);
			
			$tax = DB::table('tax')->where('status', 1)->get();
			foreach($tax as $receipt_tax ){
				$tax_name = $receipt_tax->name;
				$tax_percentage = $receipt_tax->percentage;
				DB::table('receipt_tax')->insert(
					['parent_id' => $receipt_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]
				);
			}
			return $receipt_id;
		    
		});
		
		return $receipt_id;
    }
	public function receiptrebate_ajax($receipt_no)
	{
		$receipt_info = DB::table('receipt')
		->where([
			['id',$receipt_no],
			['status','1'],
			])
		->first();
		
		if(!empty($receipt_info)){ 
			if(!empty($receipt_info->booking_no)){
				$booking_no = $receipt_info->booking_no;
				$receipt = DB::table('receipt')
				->select('receipt.*',
						DB::raw('SUM(receipt_bookingfacility.rebate_safai) as safai'),
						DB::raw('SUM(receipt_bookingfacility.rebate_electricity) as electricity'),
						DB::raw('SUM(receipt_bookingfacility.rebate_catering) as catering'),
						DB::raw('SUM(receipt_bookingfacility.rebate_tentage) as tentage'))
				->where([
						['receipt.booking_no',$booking_no],
						['receipt.receipt_type','1'],
						['receipt.status','1'],
						])
				->leftJoin('receipt_bookingfacility', 'receipt.id', 'receipt_bookingfacility.parent_id')
		        ->first();
		        
				$catering_cost = DB::table('receipt')
				->select('receipt_catering.*')
				->where([
						['receipt.booking_no',$booking_no],
						//['receipt.receipt_type','4'],
						['receipt.status','1'],
						])
				->leftJoin('receipt_catering','receipt_catering.parent_id','receipt.id')
		        ->first();

		        print_r(json_encode( array('receipt'=>$receipt,'cateringcost'=>$catering_cost)));
			}
		}
		
		else{
			print_r(json_encode( array('receipt'=>'','cateringcost'=>'')));
		}
		
	}
}
