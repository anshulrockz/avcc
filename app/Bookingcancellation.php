<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Bookingcancellation extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{		
		return DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'),DB::raw('SUM(security_total) as security_amount'))
			->where([
				['booking.status','1'],
				['booking.booking_status','2']
				])
			->orWhere('booking.booking_status','3')
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->orderBy('booking.id', 'desc')
            ->get();
	}
	public function booking_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date("Y-m-d",strtotime($to_date."+1 day"));
		return DB::table('booking')
			->select('booking.*',DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'),DB::raw('SUM(security_total) as security_amount'))
			->where([
				['booking.status','1'],
				['booking.cancel_booking','1']
				])
			->whereBetween('booking.created_at', [$from_date, $to_date])
            ->leftJoin('bookingfacility', 'bookingfacility.booking_id', '=', 'booking.id')
            ->groupBy('booking.id')
            ->orderBy('booking.id', 'desc')
            ->get();
	}
}
