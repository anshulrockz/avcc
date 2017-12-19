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
		->select('booking_id',DB::raw('SUM(est_catering) as est_catering'),DB::raw('SUM(st_caterer) as st_caterer'),DB::raw('SUM(vat_caterer) as vat_caterer'))
		->where([
		['receipt.status','1'],
		['receipt.est_catering','>','0']
		])
		->groupBy('receipt.booking_id')
		->orderBy('receipt.booking_id', 'desc')
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
