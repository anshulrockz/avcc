<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Vatregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function booking_list()
	{
		return DB::table('receipt')
			->select('receipt.*','receipt.id as receipt_no',DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'),DB::raw('SUM(security_total) as security_amount'))
			->where([
			['receipt.status','1'],
			['receipt.receipt_status','1'],
			])
            ->leftJoin('receiptfacility', 'receiptfacility.receipt_id', '=', 'receipt.id')
            ->orderBy('receipt.id', 'desc')
            ->groupBy('receipt.id')
            ->get();   
	}
	public function booking_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('receipt')
			->select('receipt.*','receipt.id as receipt_no',DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUM(servicetax_total) as service_tax'),DB::raw('SUM(vat_total) as vat'),DB::raw('SUM(security_total) as security_amount'))
			->where([
			['receipt.status','1'],
			['receipt.receipt_status','1'],
			])
			->whereBetween('receipt.function_date', [$from_date, $to_date])
            ->leftJoin('receiptfacility', 'receiptfacility.receipt_id', '=', 'receipt.id')
            ->orderBy('receipt.id', 'desc')
            ->groupBy('receipt.id')
            ->get();
	}
}
