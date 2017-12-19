<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receipt extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function receipt_list()
	{
		return DB::table('receipt')->where('status','1')->orderBy('id', 'desc')->get();
	}
    public function receipt_add($booking_no,$party_name,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$contractor,$est_cof,$vat_supplier,$est_catering,$vat_caterer,$st_caterer,$est_tentage,$vat_tent,$st_tent)
    {
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$booking_no,$party_name,$phone,$mobile,$membership_no,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$function_date,$contractor,$est_cof,$vat_supplier,$est_catering,$vat_caterer,$st_caterer,$est_tentage,$vat_tent,$st_tent) {
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
						$totalst = $value->service_tax;
						$totalvat = $value->vat;
						$totalbill = $value->total_amount;
						$cancel_booking = $value->cancel_booking;
						$cancel_date = $value->cancel_date;
						$cancel_percentage = $value->cancel_percentage;
						$cancel_amount = $value->cancel_amount;
						$booking_status = $value->booking_status;
						$tax_status = $value->tax_status;
						$misc = $value->misc;
						$misc_amount = $value->misc_amount;
						$others = $value->others;
						$others_amount = $value->others_amount;
					}
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['booking_id' => $booking_id,'receipt_type' => '3','booking_no' => $booking_no,'booking_date' => $booking_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'contractor_id' => $contractor,'est_cof' => $est_cof,'vat_supplier' => $vat_supplier,'est_catering' => $est_catering,'vat_caterer' => $vat_caterer,'st_caterer' => $st_caterer,'est_tentage' => $est_tentage,'vat_tent' => $vat_tent,'st_tent' => $st_tent,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'party_name' => $party_name,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'service_tax' => $totalst,'vat' => $totalvat,'total_amount' => $totalbill,'cancel_booking' => $cancel_booking,'cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,'booking_status' => $booking_status,'tax_status' => $tax_status,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $misc,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
					);
				}
				else{
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['receipt_type' => '3','party_name' => $party_name,'phone' => $phone,'mobile' => $mobile,'membership_no' => $membership_no,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'contractor_id' => $contractor,'est_cof' => $est_cof,'vat_supplier' => $vat_supplier,'est_catering' => $est_catering,'vat_caterer' => $vat_caterer,'st_caterer' => $st_caterer,'est_tentage' => $est_tentage,'vat_tent' => $vat_tent,'st_tent' => $st_tent,'created_at' => $this->date,'created_by' => $user_id]
					);
				}
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
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
	public function receipt_cancel($id)
	{
		$user_id = Auth::id();
		return DB::table('receipt')
            ->where('id', $id)
            ->update(['receipt_status' => '2','updated_at' => $this->date,'updated_by' => $user_id]);
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
			->select('receiptfacility.*','facility.name as facility_name','facility.sac_code')
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
	public function sub_total($id)
	{
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(total_amount) as total'))
                ->where([
			    ['status', '1'],
			    ['receipt_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function servicetax_total($id)
	{
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(servicetax_total) as total'))
                ->where([
			    ['status', '1'],
			    ['receipt_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function vat_total($id)
	{
		$data = DB::table('receiptfacility')
                ->select(DB::raw('SUM(vat_total) as total'))
                ->where([
			    ['status', '1'],
			    ['receipt_id', $id]])
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
                ->select(DB::raw('SUM(security_total) as total'))
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
	public function global_vat()
	{
		$data = DB::table('tax')
                ->where([
                ['status', '1'],
                ['name', 'SGST'],
                ])
                ->first();
        $count = count($data);
        if($count>0){
			return $data->percentage;
		}
		else{
			return '0.00';
		}
	}
	public function global_st()
	{
		$data = DB::table('tax')
                ->where([
                ['status', '1'],
                ['name', 'CGST'],
                ])
                ->first();
        $count = count($data);
        if($count>0){
			return $data->percentage;
		}
		else{
			return '0.00';
		}
	}
	public function getRebate($booking_no)
	{
		$receipt = DB::table('receipt')
		->select('booking_id')
		->where([
			['booking_no',$booking_no],
			['receipt_type','1'],
			['receipt_status','1'],
			['status','1'],
			])
		->first();

		if(!empty($receipt)){
			$booking_id = $receipt->booking_id;
			return DB::table('receiptfacility')
			->select(DB::raw('SUM(receiptfacility.rebate_safai) as safai'),DB::raw('SUM(receiptfacility.rebate_electricity) as electricity'),DB::raw('SUM(receiptfacility.rebate_catering) as catering'),DB::raw('SUM(receiptfacility.rebate_tentage) as tentage'))
			->where([
				['receipt.booking_id',$booking_id],
				['receipt.receipt_type','1'],
				['receipt.receipt_status','1'],
				['receipt.status','1'],
				])
			->leftJoin('receipt', 'receipt.id', '=', 'receiptfacility.receipt_id')
			->groupBy('receipt.id')
			->first();
		}
		else{
			return false;
		}
		
	}
	public function bookingdetails_ajax($booking_no,$refund_type)
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
			['booking_status','1'],
			['booking.status','1']
			])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->get();
		}
		print_r(json_encode( array($booking_details)));
	}
}
