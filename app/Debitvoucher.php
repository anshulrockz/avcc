<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Debitvoucher extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function debitvoucher_list()
	{
		$debitvoucher = DB::table('debitvoucher')
            ->where('status', '1')
            ->get();
		return $debitvoucher;
	}
	public function debitvoucher_add($voucher_date,$rv_no,$rv_date,$party_name,$function_date,$cheque_no,$cheque_date,$achead_id,$paid_to,$security_amount,$remarks)
    {
		$user_id = Auth::id();
		$voucher_date = date_format(date_create($voucher_date),"Y-m-d");
		if(!empty($rv_date)){
			$rv_date = date_format(date_create($rv_date),"Y-m-d");
		}
		if(!empty($function_date)){
			$function_date = date_format(date_create($function_date),"Y-m-d");
		}
		if(!empty($cheque_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		$voucher_id = DB::table('debitvoucher')->insertGetId(
			    ['voucher_date' => $voucher_date,'rv_no' => $rv_no,'rv_date' => $rv_date,'party_name' => $party_name,'function_date' => $function_date,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'achead_id' => $achead_id,'paid_to' => $paid_to,'security_amount' => $security_amount,'remarks' => $remarks,'created_at' => $this->date,'created_by' => $user_id]
		);
		return $voucher_id;
    }
    public function debitvoucher_edit($id)
	{
		$debitvoucher = DB::table('debitvoucher')
			->select('debitvoucher.*','accounthead.name as achead_name','contractor.name as contractor_name')
            ->where('debitvoucher.id',$id)
            ->leftJoin('accounthead', 'debitvoucher.achead_id', '=', 'accounthead.id')
            ->leftJoin('contractor', 'debitvoucher.paid_to', '=', 'contractor.id')
            ->get();
		return $debitvoucher;
	}
	public function debitvoucher_update($id,$voucher_date,$rv_no,$rv_date,$party_name,$function_date,$cheque_no,$cheque_date,$achead_id,$paid_to,$security_amount,$remarks)
    {
		$user_id = Auth::id();
		$voucher_date = date_format(date_create($voucher_date),"Y-m-d");
		if(!empty($rv_date)){
			$rv_date = date_format(date_create($rv_date),"Y-m-d");
		}
		if(!empty($function_date)){
			$function_date = date_format(date_create($function_date),"Y-m-d");
		}
		if(!empty($cheque_date)){
			$cheque_date = date_format(date_create($cheque_date),"Y-m-d");
		}
		return DB::table('debitvoucher')
            ->where('id', $id)
            ->update(['voucher_date' => $voucher_date,'rv_no' => $rv_no,'rv_date' => $rv_date,'party_name' => $party_name,'function_date' => $function_date,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'achead_id' => $achead_id,'paid_to' => $paid_to,'security_amount' => $security_amount,'remarks' => $remarks,'updated_at' => $this->date,'updated_by' => $user_id]
		);
    }
    public function debitvoucher_delete($id)
	{
		$user_id = Auth::id();
		return DB::table('debitvoucher')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
