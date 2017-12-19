<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receiptrent extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function receipt_list()
	{
		return DB::table('receipt')
		->where([
		['status','1'],
		['receipt_type','5'],
		])
		->orderBy('id', 'desc')
		->get();
	}
    public function receipt_add($party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax)
    {
		$user_id = Auth::id();
		if(empty($with_tax)){
			$with_tax = 0;
		}
		$receipt_id = DB::table('receipt')->insertGetId(
			    ['receipt_type' => '5','party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'rent_premises' => $rent_premises,'rent_store' => $rent_store,'rent_atm' => $rent_atm,'tds' => $tds,'with_tax' => $with_tax,'created_at' => $this->date,'created_by' => $user_id]
		);
		return $receipt_id;
    }
}
