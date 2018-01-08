<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;

class Receiptbooking extends Model
{
	public function receipt_list()
	{
		return DB::table('receipt_booking')
		->where('receipt.status','1')
		->select('receipt.*')
		->leftjoin('receipt','receipt.id','=','receipt_booking.parent_id')
		->groupBy('receipt.id')
		->orderBy('receipt.id','DESC')
		->get();
	}
}
