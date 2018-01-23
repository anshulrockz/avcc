<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Cateringregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		$booking_details = DB::table('booking')
		->select('booking.id as booking_id','booking.booking_no','booking.created_at as booking_date','booking.party_name','booking.function_date',DB::raw('SUM(bookingfacility.total_amount) as total_amount'),DB::raw('SUM(bookingfacility.rebate_catering) as rebate'))
		->where([
		['booking.status','1']
		])
		->leftJoin('bookingfacility', 'booking.id', '=', 'bookingfacility.booking_id')
		->orderBy('booking.id', 'desc')
		->get();
		return $booking_details;
	}
	public function receipt_list()
	{
		$receipt_details = DB::table('receipt')
		->select('receipt.id as booking_id',	DB::raw('SUM(receipt_catering.catering_cost) as est_catering')
				)
		->leftJoin('receipt_catering', 'receipt_catering.parent_id', '=', 'receipt.id')
		->where([
		['receipt.status','1'],
		['receipt_catering.catering_cost','>','0']
		])
		->groupBy('receipt.id')
		->orderBy('receipt.id', 'desc')
		->get();
		return $receipt_details;
	}
	public function booking_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		$booking_details = DB::table('booking')
		->select('booking.id as booking_id','booking.booking_no','booking.created_at as booking_date','booking.party_name','booking.function_date',DB::raw('SUM(bookingfacility.total_amount) as total_amount'),DB::raw('SUM(bookingfacility.rebate_catering) as rebate'))
		->where([
		['booking.status','1']
		])
		->leftJoin('bookingfacility', 'booking.id', '=', 'bookingfacility.booking_id')
		->orderBy('booking.id', 'desc')
		->whereBetween('booking.function_date', [$from_date, $to_date])
		->get();
		return $booking_details;
	}
}
