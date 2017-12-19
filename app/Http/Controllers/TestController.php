<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __construct()
    {
		
    }
    public function index()
    {
		$data = DB::table('receipt')
		->select('booking_id','booking_no')
		->where([
			['receipt.status','1'],
			['receipt.receipt_type','1'],
			])
		->get();
		foreach($data as $value){
			$booking_id = $value->booking_id;
			$booking_no = $value->booking_no;
			DB::table('receiptfacility')
			->where([
				['booking_id',$booking_id],
				])
			->update(['booking_no' => $booking_no]);
		}
		echo "success";
    }
}
