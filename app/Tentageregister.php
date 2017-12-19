<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Tentageregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		$booking_details = DB::table('booking')
		->select('booking.id as booking_id','booking.booking_no','booking.created_at as booking_date','booking.party_name','booking.function_date',DB::raw('SUM(bookingfacility.rebate_tentage) as rebate'))
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
		->select('booking_id',DB::raw('SUM(est_tentage) as est_tentage'),DB::raw('SUM(st_tent) as st_tent'),DB::raw('SUM(vat_tent) as vat_tent'))
		->where([
		['receipt.status','1'],
		['receipt.est_tentage','>','0']
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
		->select('booking.id as booking_id','booking.booking_no','booking.created_at as booking_date','booking.party_name','booking.function_date',DB::raw('SUM(bookingfacility.rebate_tentage) as rebate'))
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
