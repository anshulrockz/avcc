<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Vatregister;
use App\Booking;

class VatregisterController extends Controller
{
    public function __construct()
    {
		$this->vatregister = new Vatregister();
		$this->booking = new Booking();
    }
    public function index()
    {
		$booking = $this->vatregister->booking_list();
		$count = $booking->count();
		$global_vat = $this->booking->global_vat();
		return view('vatregister/list',['booking'=>$booking,'count'=>$count,'global_vat'=>$global_vat]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$booking = $this->vatregister->booking_search($from_date,$to_date);
		$count = $booking->count();
		$global_vat = $this->booking->global_vat();
		return view('vatregister/list',['booking'=>$booking,'count'=>$count,'global_vat'=>$global_vat]);
    }
}
