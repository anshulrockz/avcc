<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class TDSregister extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function tds_list()
	{
		return DB::table('receipt')
			->leftJoin('receipt_rent','receipt_rent.parent_id','receipt.id')
			->where([
			['status','1'],
			['tds','!=',''],
			])
            ->orderBy('receipt.id', 'desc')
			->get();      
	}
	public function tds_search($from_date,$to_date)
	{
		$from_date = date_format(date_create($from_date),"Y-m-d");
		$to_date = date_format(date_create($to_date),"Y-m-d");
		return DB::table('receipt')
			->where([
			['status','1'],
			['tds','!=',''],
			])
			->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$from_date, $to_date])
            ->orderBy('receipt.id', 'desc')
			->get();
	}
}
