<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tentageregister;

class TentageregisterController extends Controller
{
    public function __construct()
    {
		$this->booking = new Tentageregister();
    }
    public function index()
    {
		$booking = $this->booking->booking_list();
		$receipt = $this->booking->receipt_list();
		$count = $receipt->count();
		return view('tentageregister/list',['booking'=>$booking,'receipt'=>$receipt,'count'=>$count]);
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
		$receipt = $this->booking->receipt_list();
		$count = $receipt->count();
		return view('tentageregister/list',['booking'=>$booking,'receipt'=>$receipt,'count'=>$count]);
    }
}
