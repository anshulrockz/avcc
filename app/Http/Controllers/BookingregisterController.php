<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bookingregister;
use App\Booking;

class BookingregisterController extends Controller
{
    public function __construct()
    {
		$this->bookingregister = new Bookingregister();
		$this->booking = new Booking();
    }
    public function index()
    {
		$booking = $this->bookingregister->booking_list();
		$count = $booking->count();
		$global_st = $this->booking->global_st();
		$global_vat = $this->booking->global_vat();
		return view('bookingregister/list',['booking'=>$booking,'count'=>$count,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$booking = $this->bookingregister->booking_search($from_date,$to_date);
		$count = $booking->count();
		$global_st = $this->booking->global_st();
		$global_vat = $this->booking->global_vat();
		return view('bookingregister/list',['booking'=>$booking,'count'=>$count,'global_st'=>$global_st,'global_vat'=>$global_vat]);
    }
}
