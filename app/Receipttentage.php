<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receipttentage extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function receipt_list()
	{
		return DB::table('receipt')
		->select('receipt_tentage.*', 'receipt.*', 'contractor.name as contractor_name')
		->where([
			['receipt.status','!=','0'],
			['receipt.receipt_type','3'],
			])
		->leftJoin('receipt_tentage', 'receipt.id', '=', 'receipt_tentage.parent_id')
		->leftJoin('contractor', 'contractor.id', '=', 'receipt_tentage.contractor_id')
		->groupBy('receipt.id')
		->orderBy('receipt.id','DESC')
		->get();
	}
	
    public function receipt_add($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$function_time,$contractor,$cost_tentage,$security_deposit,$comments)
    {
		$user_id = Auth::id();
		try{
			$receipt_id = DB::transaction(function () use ($user_id,$booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$function_time,$contractor,$cost_tentage,$security_deposit,$comments) {
				$count = 0;
				if(!empty($function_date)){
					$function_date = date_format(date_create($function_date),"Y-m-d");
				}
				if(!empty($cheque_date)){
					$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
				}
				if(!empty($booking_no)){
					$data = DB::table('booking')
		                ->where([
					    ['status', '1'],
					    ['booking_no', $booking_no]])
		                ->get();
					$count = $data->count();
				}
				if($count>0){
					foreach ($data as $value){
						$booking_id = $value->id;
						$booking_date = $value->booking_date;
						$party_name = $value->party_name;
						$function_date = $value->function_date;
						$from_time = $value->from_time;
						$to_time = $value->to_time;
						$function_type = $value->function_type;
						$membership_no = $value->membership_no;
						$phone = $value->phone;
						$mobile = $value->mobile;
						$address = $value->address;
					}
					
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['function_type' => $function_type, 'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'receipt_type' => '3','booking_no' => $booking_no,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id, 'comments' => $comments]
					);
				}
				else{
					$receipt_id = DB::table('receipt')->insertGetId(
					    [ 'function_date' => $function_date,'receipt_type' => '3','booking_no' => $booking_no,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id, 'comments' => $comments]
						);
				}
				
				DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id,]);
				
				$receipt_tentage_id = DB::table('receipt_tentage')->insertGetId(
				    ['parent_id' => $receipt_id, 'contractor_id' => $contractor,'tentage_cost' => $cost_tentage]
				);
				
				DB::table('receipt_security')->insert(
				    ['parent_id' => $receipt_id, 'security' => $security_deposit]
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
		catch(\Exception $e){
			return FALSE;
		}
    }
    
    public function receipt_add_old($booking_no,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$function_time,$contractor,$est_cof,$est_catering,$est_tentage,$security_deposit,$comments)
    {
		$user_id = Auth::id();
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
				$function_date = $value->function_date;
				$membership_no = $value->membership_no;
				$phone = $value->phone;
				$mobile = $value->mobile;
				$address = $value->address;
			}
			$receipt_id = DB::table('receipt')->insertGetId(
			    ['booking_id' => $booking_id,'booking_no' => $booking_no,'booking_date' => $booking_date,'receipt_type' => '3','party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'time_period' => $function_time,'contractor_id' => $contractor,'est_cof' => $est_cof,'est_catering' => $est_catering,'est_tentage' => $est_tentage,'security_deposit' => $security_deposit,'comments' => $comments,'created_at' => $this->date,'created_by' => $user_id]
			);
		}
		else{
			$receipt_id = DB::table('receipt')->insertGetId(
			    ['booking_no' => $booking_no,'receipt_type' => '3','party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'time_period' => $function_time,'contractor_id' => $contractor,'est_cof' => $est_cof,'est_catering' => $est_catering,'est_tentage' => $est_tentage,'security_deposit' => $security_deposit,'comments' => $comments,'created_at' => $this->date,'created_by' => $user_id]
			);
		}
		return $receipt_id;
    }
	public function receipt_edit($id)
	{
		return DB::table('receipt')
			->select('receipt.*','member.name as member_name','membertype.name as member_type')
			->where('receipt.id',$id)
            ->leftJoin('member', 'member.membership_no', '=', 'receipt.membership_no')
            ->leftJoin('membertype', 'membertype.id', '=', 'member.member_type')
            ->get();
	}
    public function receipttype_name($id)
	{
		return DB::table('receipt')
			->select('receipttype.name as receipt_type')
			->where('receipt.id',$id)
            ->leftJoin('receipttype', 'receipt.receipttype_id', '=', 'receipttype.id')
            ->get();
	}
	public function receipt_facility($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		return DB::table('receiptfacility')
			->select('receiptfacility.*','facility.name as facility_name')
			->where([['receiptfacility.booking_id',$booking_id],['receiptfacility.status','1']])
            ->leftJoin('facility', 'receiptfacility.facility_id', '=', 'facility.id')
            ->get();
	}
	public function total_receiptamount($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(booking_rate) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $booking_id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function safai_charges($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(safai_general) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $booking_id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function generator_charges($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(generator_charges) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $booking_id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function ac_charges($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(ac_charges) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $booking_id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function security_charges($id)
	{
		$booking = DB::table('receipt')
			->select('booking_id')
			->where('id',$id)
            ->get();
        foreach ($booking as $value){
			$booking_id = $value->booking_id;
		}
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(security_charges) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $booking_id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function other_charges($id)
	{
		$data = DB::table('receipt')
                ->select('misc_amount')
                ->where([
			    ['status', '1'],
			    ['id', $id]])
                ->get();
		foreach ($data as $value){
			$misc_amount = $value->misc_amount;
		}
		return $misc_amount;
	}
	public function bookingdetails_ajax($booking_no)
	{
		$booking_details = DB::table('booking')->where('booking_no',$booking_no)->get();
		print_r(json_encode( array($booking_details)));
	}
}
