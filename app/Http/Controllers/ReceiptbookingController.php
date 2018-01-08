<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receiptbooking;

class ReceiptbookingController extends Controller
{
    public function __construct()
    {
		$this->receipt = new Receiptbooking();
    }
	
	public function index()
	{
		$receipt = $this->receipt->receipt_list();
		$count = $receipt->count();
		return view('receipt-booking/list')->with('receipt',$receipt)->with('count',$count);
	}
}
