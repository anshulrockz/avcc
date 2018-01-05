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
		return DB::table('receipt_fd')
		->leftJoin('receipt', 'receipt.id', '=', 'receipt_fd.parent_id')
		->where([
		['receipt.status','1'],
		])
		->orderBy('receipt_fd.id', 'desc')
		->get();
	}
	
    public function receipt_add($party_name,$party_gstin,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$fd_principal_amt,$fd_interest,$tds,$comments)
    {
		$user_id = Auth::id();
		
		try{
			$receipt_id = DB::transaction(function () use ($user_id,$party_name,$party_gstin,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$fd_principal_amt,$fd_interest,$tds,$comments)
			{
				$receipt_id = DB::table('receipt')->insertGetId(
					    ['receipt_type' => '9', 'party_name' => $party_name,'party_gstin' => $party_gstin,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn,'created_at' => $this->date,'updated_at' => $this->date,'created_by' => $user_id,'updated_by' => $user_id]
				);
				
				DB::table('receipt')->where('id', $receipt_id)->update(['receipt_no' => $receipt_id,]);
				
				$receipt_fd_id = DB::table('receipt_fd')->insertGetId(
				    ['parent_id' => $receipt_id, 'principal_amount' => $fd_principal_amt,'interest' => $fd_interest,'tds' => $tds, 'comments' => $comments]
				);
				
				return $receipt_id;
			});
			return $receipt_id;
		}
		catch(\Exception $e){
			return FALSE;
		}
    }
}
