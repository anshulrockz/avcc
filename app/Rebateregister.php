<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Rebateregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
	public function rebate_list()
	{
		return DB::table('receipt')
		->select('receipt.*','contractor.name as contractor_name','receipt_rebate.rebate_no','receipt_rebate.safai','receipt_rebate.tentage','receipt_rebate.catering','receipt_rebate.food','receipt_rebate.electricity')
		->where([
			['receipt.status','1'],
			['receipt.receipt_type','8'],
			['receipt.receipt_status','1'],
			])
		->leftJoin('receipt_rebate','receipt_rebate.parent_id','receipt.id')
		->leftJoin('contractor', 'contractor.id', '=', 'receipt.contractor_id')
		->groupBy('receipt.id')
		->orderBy('receipt.id','DESC')
		->get();
	}
	public function rebate_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('receipt')
		->select('receipt.*','contractor.name as contractor_name','receipt_rebate.rebate_no','receipt_rebate.safai','receipt_rebate.tentage','receipt_rebate.catering','receipt_rebate.food','receipt_rebate.electricity')
		->where([
			['receipt.status','1'],
			['receipt.receipt_type','8'],
			['receipt.receipt_status','1'],
			])
		->leftJoin('receipt_rebate','receipt_rebate.parent_id','receipt.id')
		->leftJoin('contractor', 'contractor.id', '=', 'receipt.contractor_id')
		->groupBy('receipt.id')
		->whereBetween('receipt.function_date', [$from_date, $to_date])
		->orderBy('receipt.id','DESC')
		->get();
	}
}
