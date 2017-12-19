<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receiptfd extends Model
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
		['receipt_type','6'],
		])
		->orderBy('id', 'desc')
		->get();
	}
    public function receipt_add($party_name,$party_gstin,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$fd_principal_amt,$fd_interest,$tds)
    {
		$user_id = Auth::id();
		$receipt_id = DB::table('receipt')->insertGetId(
			    ['receipt_type' => '6','party_name' => $party_name,'party_gstin' => $party_gstin,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'fd_principal_amt' => $fd_principal_amt,'fd_interest' => $fd_interest,'tds' => $tds,'created_at' => $this->date,'created_by' => $user_id]
		);
		return $receipt_id;
    }
}
