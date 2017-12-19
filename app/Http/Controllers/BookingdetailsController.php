<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bookingdetails;
use App\Facility;
use Carbon\Carbon;

class BookingdetailsController extends Controller
{
    public function __construct()
    {
		$this->booking = new Bookingdetails();
		$this->facility = new Facility();
    }
    public function index()
    {
		$from_date = Carbon::now()->startOfMonth();
		$to_date = Carbon::now()->endOfMonth();
		$booking = $this->booking->booking_list();
		$count = $booking->count();
		$facility = $this->facility->facility_list();
		$facility_booking = $this->booking->facility_booking($from_date,$to_date);
//		echo "<pre>";
//		print_r($facility_booking);
		return view('bookingdetails/list',['booking'=>$booking,'count'=>$count,'facility'=>$facility,'from_date'=>$from_date,'to_date'=>$to_date,'facility_booking'=>$facility_booking]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$booking = $this->booking->booking_search($from_date,$to_date);
		$count = $booking->count();
		$facility = $this->facility->facility_list();
		$facility_booking = $this->booking->facility_booking($from_date,$to_date);
//		echo "<pre>";
//		print_r($facility_booking);
		return view('bookingdetails/list',['booking'=>$booking,'count'=>$count,'facility'=>$facility,'from_date'=>$from_date,'to_date'=>$to_date,'facility_booking'=>$facility_booking]);
    }
}
