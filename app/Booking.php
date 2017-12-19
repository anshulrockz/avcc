<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Booking extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		return DB::table('booking')
			->select('booking.*','receipt.id as receipt_id')
			->where([
			['booking.status','1'],
			['booking.booking_status','!=','3']
			])
            ->leftJoin('receipt', 'receipt.booking_id', '=', 'booking.id')
            ->orderBy('booking.id', 'desc')
            ->groupBy('booking.id')
            ->get();
	}
    public function booking_add($booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount)
    {
		$user_id = Auth::id();
		$from_time = date("H:i", strtotime($from_time));
		$to_time = date("H:i", strtotime($to_time));
		
		try{
			$bid = DB::transaction(function () use ($user_id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount) {
			    $booking_date = date_format(date_create($booking_date),"Y-m-d");
				$function_date = date_format(date_create($function_date),"Y-m-d");
				if(!empty($bill_date)){
					$bill_date = date_format(date_create($bill_date),"Y-m-d");
				}
				if(empty($is_sponsor)){
					$is_sponsor = '0';
				}
				$booking_id = DB::table('booking')->insertGetId(
				    ['booking_no' => $booking_no,'booking_date' => $booking_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
				);
				if(count($facility>0)){
					for ($i = 0; $i < count($facility); ++$i) {
						$facility1 = $facility[$i];
						$quantity1 = $quantity[$i];
						$noofdays1 = $noofdays[$i];
						$from_date1 = $from_date[$i];
						$to_date1 = $to_date[$i];
						$booking_rate1 = $booking_rate[$i];
						$generator_charges1 = $generator_charges[$i];
						$generatorTotal = $generator_charges1*$quantity1*$noofdays1;
						$ac_charges1 = $ac_charges[$i];
						$acTotal = $ac_charges1*$quantity1*$noofdays1;
						$safai_general1 = $safai_general[$i];
						$safaiTotal = $safai_general1*$quantity1*$noofdays1;
						$security_charges1 = $security_charges[$i];
						$securityTotal = $security_charges1*$quantity1;
						$rebate_safai1 = $rebate_safai[$i];
						$rebate_tentage1 = $rebate_tentage[$i];
						$rebate_catering1 = $rebate_catering[$i];
						$rebate_electricity1 = $rebate_electricity[$i];
						$servicetaxPercentage1 = $servicetaxPercentage[$i];
						$servicetaxAmount1 = $servicetaxAmount[$i];
						$servicetaxTotal = $servicetaxAmount1*$quantity1*$noofdays1;
						$vatPercentage1 = $vatPercentage[$i];
						$vatAmount1 = $vatAmount[$i];
						$vatTotal = $vatAmount1*$quantity1*$noofdays1;
						$totalAmount1 = $totalAmount[$i];
						if($facility1!=''){
							$bookingfacility_id = DB::table('bookingfacility')->insertGetId(
								['booking_id' => $booking_id,'facility_id' => $facility1,'quantity' => $quantity1,'noofdays' => $noofdays1,'from_date' => $from_date1,'to_date' => $to_date1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'generator_total' => $generatorTotal,'ac_charges' => $ac_charges1,'ac_total' => $acTotal,'safai_general' => $safai_general1,'safai_total' => $safaiTotal,'security_charges' => $security_charges1,'security_total' => $securityTotal,'rebate_safai' => $rebate_safai1,'rebate_tentage' => $rebate_tentage1,'rebate_catering' => $rebate_catering1,'rebate_electricity' => $rebate_electricity1,'servicetax_percentage' => $servicetaxPercentage1,'servicetax_amount' => $servicetaxAmount1,'servicetax_total' => $servicetaxTotal,'vat_percentage' => $vatPercentage1,'vat_amount' => $vatAmount1,'vat_total' => $vatTotal,'total_amount' => $totalAmount1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
							);
						}
					}
				}
				return $booking_id;
			});
			return $bid;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
    }
    public function receipt_created($id)
	{
		$result = DB::table('booking')
                ->select('booking.booking_status')
                ->where('id', $id)
                ->get();
        foreach($result as $value){
			$booking_status = $value->booking_status;
		}
        return $booking_status;
	}
	public function bookingtype_name($id)
	{
		return DB::table('booking')
			->select('bookingtype.name as booking_type')
			->where('booking.id',$id)
            ->leftJoin('bookingtype', 'booking.bookingtype_id', '=', 'bookingtype.id')
            ->get();
	}
	public function booking_facility($id)
	{
		return DB::table('bookingfacility')
			->select('bookingfacility.*','facility.name as facility_name')
			->where([['bookingfacility.booking_id',$id],['bookingfacility.status','1']])
            ->leftJoin('facility', 'bookingfacility.facility_id', '=', 'facility.id')
            ->get();
	}
	public function booking_edit($id)
	{
		return DB::table('booking')
			->select('booking.*','member.name as member_name','membertype.name as member_type','membertype.id as membertype_id','member.membership_no')
			->where('booking.id',$id)
            ->leftJoin('member', 'member.membership_no', '=', 'booking.membership_no')
            ->leftJoin('membertype', 'membertype.id', '=', 'member.member_type')
            ->get();
	}
	public function booking_update($id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount)
    {
		$user_id = Auth::id();
		$from_time = date("H:i", strtotime($from_time));
		$to_time = date("H:i", strtotime($to_time));
		try{
			DB::transaction(function () use ($user_id,$id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount) {
				$booking_date = date_format(date_create($booking_date),"Y-m-d");
				$function_date = date_format(date_create($function_date),"Y-m-d");
				if(!empty($bill_date)){
					$bill_date = date_format(date_create($bill_date),"Y-m-d");
				}
				$booking_id = DB::table('booking')
		            ->where('id', $id)
		            ->update(['booking_no' => $booking_no,'booking_date' => $booking_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'updated_at' => $this->date,'updated_by' => $user_id]);
		        if(count($facility>0)){
			        DB::table('bookingfacility')
			            ->where('booking_id', $id)
			            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
					for ($i = 0; $i < count($facility); ++$i) {
						$facility1 = $facility[$i];
						$quantity1 = $quantity[$i];
						$noofdays1 = $noofdays[$i];
						$from_date1 = $from_date[$i];
						$to_date1 = $to_date[$i];
						$booking_rate1 = $booking_rate[$i];
						$generator_charges1 = $generator_charges[$i];
						$generatorTotal = $generator_charges1*$quantity1*$noofdays1;
						$ac_charges1 = $ac_charges[$i];
						$acTotal = $ac_charges1*$quantity1*$noofdays1;
						$safai_general1 = $safai_general[$i];
						$safaiTotal = $safai_general1*$quantity1*$noofdays1;
						$security_charges1 = $security_charges[$i];
						$securityTotal = $security_charges1*$quantity1;
						$rebate_safai1 = $rebate_safai[$i];
						$rebate_tentage1 = $rebate_tentage[$i];
						$rebate_catering1 = $rebate_catering[$i];
						$rebate_electricity1 = $rebate_electricity[$i];
						$servicetaxPercentage1 = $servicetaxPercentage[$i];
						$servicetaxAmount1 = $servicetaxAmount[$i];
						$servicetaxTotal = $servicetaxAmount1*$quantity1*$noofdays1;
						$vatPercentage1 = $vatPercentage[$i];
						$vatAmount1 = $vatAmount[$i];
						$vatTotal = $vatAmount1*$quantity1*$noofdays1;
						$totalAmount1 = $totalAmount[$i];
						if($facility1!=''){
							$bookingfacility_id = DB::table('bookingfacility')->insertGetId(
								['booking_id' => $id,'facility_id' => $facility1,'quantity' => $quantity1,'noofdays' => $noofdays1,'from_date' => $from_date1,'to_date' => $to_date1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'generator_total' => $generatorTotal,'ac_charges' => $ac_charges1,'ac_total' => $acTotal,'safai_general' => $safai_general1,'safai_total' => $safaiTotal,'security_charges' => $security_charges1,'security_total' => $securityTotal,'rebate_safai' => $rebate_safai1,'rebate_tentage' => $rebate_tentage1,'rebate_catering' => $rebate_catering1,'rebate_electricity' => $rebate_electricity1,'servicetax_percentage' => $servicetaxPercentage1,'servicetax_amount' => $servicetaxAmount1,'servicetax_total' => $servicetaxTotal,'vat_percentage' => $vatPercentage1,'vat_amount' => $vatAmount1,'vat_total' => $vatTotal,'total_amount' => $totalAmount1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
							);
						}
					}
				}
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
    }
	public function partial_update($id,$booking_no,$booking_date,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$receipt_created,$is_sponsor,$phone,$mobile,$address,$noofpersons,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount)
    {
		$booking = DB::table('receipt')
			->where([
			['booking_id',$id],
			['receipt_type','1'],
			])
            ->get();
        foreach($booking as $value){
			$oldreceipt_id = $value->id;
			$payment_mode = $value->payment_mode;
			$cheque_no = $value->cheque_no;
			$cheque_date = $value->cheque_date;
			$cheque_drawn = $value->cheque_drawn;
			$with_tax = $value->with_tax;
			$with_security = $value->with_security;
		}
		$user_id = Auth::id();
		$from_time = date("H:i", strtotime($from_time));
		$to_time = date("H:i", strtotime($to_time));
		if(empty($is_sponsor)){
			$is_sponsor = '0';
		}
		try{
			$bid = DB::transaction(function () use ($user_id,$id,$oldreceipt_id,$booking_no,$booking_date,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$party_name,$party_gstin,$reverse_charges,$function_date,$from_time,$to_time,$function_type,$bill_no,$bill_date,$membership_no,$receipt_created,$is_sponsor,$phone,$mobile,$address,$noofpersons,$with_tax,$with_security,$misc,$misc_amount,$others,$others_amount,$facility,$quantity,$noofdays,$from_date,$to_date,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_electricity,$servicetaxPercentage,$servicetaxAmount,$vatPercentage,$vatAmount,$totalAmount) {
				$booking_date = date_format(date_create($booking_date),"Y-m-d");
				$function_date = date_format(date_create($function_date),"Y-m-d");
				if(!empty($bill_date)){
					$bill_date = date_format(date_create($bill_date),"Y-m-d");
				}
				$booking_id = DB::table('booking')->insertGetId(
				    ['booking_no' => $booking_no,'booking_date' => $booking_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'booking_status' => '1','phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'with_tax' => $with_tax,'with_security' => $with_security,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
				);
				if($receipt_created == '1'){
					$receipt_id = DB::table('receipt')->insertGetId(
					    ['booking_id' => $booking_id,'receipt_type' => '1','booking_no' => $booking_no,'booking_date' => $booking_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'is_sponsor' => $is_sponsor,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'with_tax' => $with_tax,'with_security' => $with_security,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
					);
				}
				if(count($facility>0)){
					for ($i = 0; $i < count($facility); ++$i) {
						$facility1 = $facility[$i];
						$quantity1 = $quantity[$i];
						$noofdays1 = $noofdays[$i];
						$from_date1 = $from_date[$i];
						$to_date1 = $to_date[$i];
						$booking_rate1 = $booking_rate[$i];
						$generator_charges1 = $generator_charges[$i];
						$generatorTotal = $generator_charges1*$quantity1*$noofdays1;
						$ac_charges1 = $ac_charges[$i];
						$acTotal = $ac_charges1*$quantity1*$noofdays1;
						$safai_general1 = $safai_general[$i];
						$safaiTotal = $safai_general1*$quantity1*$noofdays1;
						$security_charges1 = $security_charges[$i];
						$securityTotal = $security_charges1*$quantity1;
						$rebate_safai1 = $rebate_safai[$i];
						$rebate_tentage1 = $rebate_tentage[$i];
						$rebate_catering1 = $rebate_catering[$i];
						$rebate_electricity1 = $rebate_electricity[$i];
						$servicetaxPercentage1 = $servicetaxPercentage[$i];
						$servicetaxAmount1 = $servicetaxAmount[$i];
						$servicetaxTotal = $servicetaxAmount1*$quantity1*$noofdays1;
						$vatPercentage1 = $vatPercentage[$i];
						$vatAmount1 = $vatAmount[$i];
						$vatTotal = $vatAmount1*$quantity1*$noofdays1;
						$totalAmount1 = $totalAmount[$i];
						if($facility1!=''){
							$bookingfacility_id = DB::table('bookingfacility')->insertGetId(
								['booking_id' => $booking_id,'facility_id' => $facility1,'quantity' => $quantity1,'noofdays' => $noofdays1,'from_date' => $from_date1,'to_date' => $to_date1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'generator_total' => $generatorTotal,'ac_charges' => $ac_charges1,'ac_total' => $acTotal,'safai_general' => $safai_general1,'safai_total' => $safaiTotal,'security_charges' => $security_charges1,'security_total' => $securityTotal,'rebate_safai' => $rebate_safai1,'rebate_tentage' => $rebate_tentage1,'rebate_catering' => $rebate_catering1,'rebate_electricity' => $rebate_electricity1,'servicetax_percentage' => $servicetaxPercentage1,'servicetax_amount' => $servicetaxAmount1,'servicetax_total' => $servicetaxTotal,'vat_percentage' => $vatPercentage1,'vat_amount' => $vatAmount1,'vat_total' => $vatTotal,'total_amount' => $totalAmount1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
							);
							if($receipt_created == '1'){
								$receiptfacility_id = DB::table('receiptfacility')->insertGetId(
									['receipt_id' => $receipt_id,'booking_id' => $booking_id,'facility_id' => $facility1,'quantity' => $quantity1,'noofdays' => $noofdays1,'from_date' => $from_date1,'to_date' => $to_date1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'generator_total' => $generatorTotal,'ac_charges' => $ac_charges1,'ac_total' => $acTotal,'safai_general' => $safai_general1,'safai_total' => $safaiTotal,'security_charges' => $security_charges1,'security_total' => $securityTotal,'rebate_safai' => $rebate_safai1,'rebate_tentage' => $rebate_tentage1,'rebate_catering' => $rebate_catering1,'rebate_electricity' => $rebate_electricity1,'servicetax_percentage' => $servicetaxPercentage1,'servicetax_amount' => $servicetaxAmount1,'servicetax_total' => $servicetaxTotal,'vat_percentage' => $vatPercentage1,'vat_amount' => $vatAmount1,'vat_total' => $vatTotal,'total_amount' => $totalAmount1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
								);
							}
						}
					}
				}
				DB::table('booking')
		            ->where('id', $id)
		            ->update(['cancel_against' => $booking_id,'booking_status' => '3','cancel_date' => $this->date,'updated_at' => $this->date,'updated_by' => $user_id]);
		        if($receipt_created == '1'){
			        DB::table('receipt')
			            ->where('booking_id', $id)
			            ->update(['cancel_against' => $receipt_id,'receipt_status' => '2','updated_at' => $this->date,'updated_by' => $user_id]);
		        }
		        return $booking_id;
			});
			return $bid;
		}
		catch ( \Exception $e ){
			echo $e->getMessage();
			die;
			return FALSE;
		}
    }
	public function booking_cancel($id,$cancel_date,$cancel_percentage,$cancel_amount)
    {
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$id,$cancel_date,$cancel_percentage,$cancel_amount) {
			    $cancel_date = date_format(date_create($cancel_date),"Y-m-d");
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
			    if($cancel_percentage == '0'){
					$cancel_amount = 0;
				}
				else{
					//Get cancellation_amount1
					$booking = DB::table('booking')
						->select('misc_amount','others_amount','function_date')
						->where([
						['id',$id],
						['booking_status','1'],
						['status','1'],
						])
			            ->get();
			        foreach($booking as $value){
						$misc_amount = $value->misc_amount;
						$others_amount = $value->others_amount;
						$function_date = $value->function_date;
						$cancel_amount1 = ($misc_amount+$others_amount)*$cancel_percentage/100;
					}
					// Get Month & Date Difference
					$month = getMonth($cancel_date,$function_date);
					$diff_in_days = getDateDifference($cancel_date,$function_date);
					//Get cancellation_amount2
					$bookingfacility = DB::table('bookingfacility')
						->select('id')
						->where([
						['booking_id',$id],
						['status','1'],
						])
			            ->get();
			        $cancel_amount2 = 0;
			        foreach($bookingfacility as $value){
						$bookingfacility_id = $value->id;
						$cancel_amount2 += getFacilityCancelAmount($bookingfacility_id,$cancel_percentage,$month,$diff_in_days);
					}
					//Final cancellation amount
					$cancel_amount = $cancel_amount1+$cancel_amount2;
				}
				DB::table('booking')
		            ->where('id', $id)
		            ->update(['booking_status' => '2','cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,'updated_at' => $this->date,'updated_by' => $user_id]);
		        DB::table('receipt')
		            ->where('booking_id', $id)
		            ->update(['receipt_status' => '2','updated_at' => $this->date,'updated_by' => $user_id]);
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}    
    }
    public function booking_delete($id)
	{
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$id) {
			    DB::table('booking')
		            ->where('id', $id)
		            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
		        DB::table('bookingfacility')
		            ->where('booking_id', $id)
		            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
	}
	public function addfacility_ajax($membertype_id,$facility_id,$from_date,$to_date)
	{
		$facility = DB::table('facility')
			->select('facility.*','facilitybookingrate.booking_rate as booking_rate','facilitybookingrate.generator_charges as generator_charges','facilitybookingrate.ac_charges as ac_charges','facilitybookingrate.safai_general as safai_general','facilitybookingrate.security_charges as security_charges')
            ->leftJoin('facilitybookingrate', 'facilitybookingrate.facility_id', '=', 'facility.id')
            ->where([
			    ['facility.status', '1'],
			    ['facility.id', $facility_id],
			    ['facilitybookingrate.membertype_id', $membertype_id],
			    ['facilitybookingrate.status','1']])
            ->get();
        $tax = DB::table('tax')
        	->select('tax.*')
        	->leftJoin('facilitytax', 'facilitytax.tax_id', '=', 'tax.id')
        	->where([
			    ['tax.status', '1'],
			    ['facilitytax.facility_id', $facility_id],
			    ['facilitytax.status','1']])
            ->get();
            
		print_r(json_encode( array($facility,$tax)));
	}
	public function member_ajax($membership_no)
	{
		$member = DB::table('member')
			->select('member.name','member.phone','member.mobile','member.address','membertype.name as member_type','membertype.id as membertype_id')
            ->leftJoin('membertype', 'membertype.id', '=', 'member.member_type')
            ->where([
			    ['member.status', '1'],
			    ['member.membership_no',$membership_no]])
            ->get();
           
            
		print_r(json_encode( array($member)));
	}
	public function total_bookingamount($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(booking_rate) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function sub_total($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(total_amount) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function servicetax_total($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(servicetax_total) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function vat_total($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(vat_total) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function safai_charges($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(safai_general) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function generator_charges($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(generator_charges) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function ac_charges($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(ac_charges) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function security_charges($id)
	{
		$data = DB::table('bookingfacility')
                ->select(DB::raw('SUM(security_total) as total'))
                ->where([
			    ['status', '1'],
			    ['booking_id', $id]])
                ->get();
		foreach ($data as $value){
			$total_amount = $value->total;
		}
		return $total_amount;
	}
	public function other_charges($id)
	{
		$data = DB::table('booking')
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
	public function change_status($id,$with_tax,$with_security,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn)
    {
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$id,$with_tax,$with_security,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn) {
			    $cheque_date = date_format(date_create($cheque_date),"Y-m-d");
				$change_status = DB::table('booking')
		            ->where('id', $id)
		            ->update(['with_tax' => '1','with_security' => $with_security,'booking_status' => '1','updated_at' => $this->date,'updated_by' => $user_id]);
		        $booking_data = DB::table('booking')
					->where('id',$id)
		            ->get();
		        foreach($booking_data as $value){
					$booking_no = $value->booking_no;
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
					$booking_status = $value->booking_status;
					$with_tax = $value->with_tax;
					$with_security = $value->with_security;
					$misc = $value->misc;
					$misc_amount = $value->misc_amount;
					$others = $value->others;
					$others_amount = $value->others_amount;
					
				}
				$receipt_id = DB::table('receipt')->insertGetId(
				    ['booking_id' => $id,'receipt_type' => '1','booking_no' => $booking_no,'booking_date' => $booking_date,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'function_date' => $function_date,'from_time' => $from_time,'to_time' => $to_time,'function_type' => $function_type,'bill_no' => $bill_no,'bill_date' => $bill_date,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'membership_no' => $membership_no,'phone' => $phone,'mobile' => $mobile,'address' => $address,'noofpersons' => $noofpersons,'cancel_date' => $cancel_date,'cancel_percentage' => $cancel_percentage,'cancel_amount' => $cancel_amount,'with_tax' => $with_tax,'with_security' => $with_security,'misc' => $misc,'misc_amount' => $misc_amount,'others' => $others,'others_amount' => $others_amount,'created_at' => $this->date,'created_by' => $user_id]
				);
				$receiptfacility_data = DB::table('bookingfacility')
					->where([['booking_id',$id],['status','1']])
		            ->get();
		        if(count($receiptfacility_data)>0){
					foreach($receiptfacility_data as $value){
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
							['receipt_id' => $receipt_id,'booking_id' => $booking_id,'booking_no' => $booking_no,'facility_id' => $facility_id,'quantity' => $quantity,'noofdays' => $noofdays,'from_date' => $from_date,'to_date' => $to_date,'booking_rate' => $booking_rate,'generator_charges' => $generator_charges,'generator_total' => $generator_total,'ac_charges' => $ac_charges,'ac_total' => $ac_total,'safai_general' => $safai_general,'safai_total' => $safai_total,'security_charges' => $security_charges,'security_total' => $security_total,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_electricity' => $rebate_electricity,'servicetax_percentage' => $servicetax_percentage,'servicetax_amount' => $servicetax_amount,'servicetax_total' => $servicetax_total,'vat_percentage' => $vat_percentage,'vat_amount' => $vat_amount,'vat_total' => $vat_total,'total_amount' => $total_amount,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
						);
					}
				}
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			echo $e->getMessage();
			die;
			return FALSE;
		}
    }
    public function is_receiptcreated($id)
	{
		$result = DB::table('booking')
                ->select('booking.booking_status')
                ->where('id', $id)
                ->get();
        foreach($result as $value){
			$booking_status = $value->booking_status;
		}
        return $booking_status;
	}
}
