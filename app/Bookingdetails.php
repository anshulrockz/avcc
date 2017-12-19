<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Bookingdetails extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		$from_date = Carbon::now()->startOfMonth();
		$to_date = Carbon::now()->endOfMonth();
		return DB::table('booking')
		->where([
			['status','1'],
			['booking_status','1'],
			])
		->orderBy('id', 'desc')
		->whereBetween('function_date', [$from_date, $to_date])
		->get();
	}
	public function booking_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('booking')
		->where([
			['status','1'],
			['booking_status','1'],
			])
		->orderBy('id', 'desc')
		->whereBetween('function_date', [$from_date, $to_date])
		->get();
	}
	public function facility_booking($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('bookingfacility')
		->select('bookingfacility.*','booking.booking_status')
		->where([
			['booking.status','1'],
			['booking.booking_status','1'],
			])
		->leftJoin('booking', 'bookingfacility.booking_id', '=', 'booking.id')
		->whereBetween('bookingfacility.from_date', [$from_date, $to_date])
		->whereBetween('bookingfacility.to_date', [$from_date, $to_date])
		->get();
	}
}
