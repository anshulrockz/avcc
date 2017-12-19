<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Securityamountregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		return DB::table('bookingfacility')
		->select('booking.*',DB::raw('SUM(bookingfacility.security_charges) as security_amount'))
		->where([
		['bookingfacility.status','1'],
		['booking.booking_status','1'],
		])
		->leftJoin('booking', 'booking.id', '=', 'bookingfacility.booking_id')
		->groupBy('booking.booking_no')
		->orderBy('bookingfacility.id', 'desc')
		->get();
	}
	public function booking_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('bookingfacility')
		->select('booking.*',DB::raw('SUM(bookingfacility.security_charges) as security_amount'))
		->where([
		['bookingfacility.status','1'],
		['booking.booking_status','1'],
		])
		->leftJoin('booking', 'booking.id', '=', 'bookingfacility.booking_id')
		->groupBy('booking.booking_no')
		->orderBy('bookingfacility.id', 'desc')
		->whereBetween('booking.function_date', [$from_date, $to_date])
		->get();
	}
}
