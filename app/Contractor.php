<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Contractor extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function contractor_list()
	{
		return DB::table('contractor')->where('status','1')->get();
	}
    public function contractor_add($name,$phone,$mobile,$address1,$address2,$address3,$op_balance,$opbalance_date,$rebate)
    {
		$user_id = Auth::id();
		$opbalance_date = date_format(date_create($opbalance_date),"Y-m-d");
		return $contractor_id = DB::table('contractor')->insertGetId(
		    ['name' => $name,'phone' => $phone,'mobile' => $mobile,'address1' => $address1,'address2' => $address2,'address3' => $address3,'op_balance' => $op_balance,'opbalance_date' => $opbalance_date,'rebate' => $rebate,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function contractor_edit($id)
	{
		return DB::table('contractor')->where('id',$id)->get();
	}
	public function contractor_update($id,$name,$phone,$mobile,$address1,$address2,$address3,$op_balance,$opbalance_date,$rebate)
    {
		$user_id = Auth::id();
		$opbalance_date = date_format(date_create($opbalance_date),"Y-m-d");
		return DB::table('contractor')
            ->where('id', $id)
            ->update(['name' => $name,'phone' => $phone,'mobile' => $mobile,'address1' => $address1,'address2' => $address2,'address3' => $address3,'op_balance' => $op_balance,'opbalance_date' => $opbalance_date,'rebate' => $rebate,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function contractor_delete($id)
	{
		$user_id = Auth::id();
		$contractor = DB::table('contractor')->where('id',$id)->get();
		foreach($contractor as $value){
			$name = $value->name;
			$phone = $value->phone;
			$mobile = $value->mobile;
			$address1 = $value->address1;
			$address2 = $value->address2;
			$address3 = $value->address3;
			$op_balance = $value->op_balance;
			$opbalance_date = $value->opbalance_date;
			$rebate = $value->rebate;
		}
		return DB::table('contractor')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
	public function getContractorName($id)
	{
		$contractor = DB::table('contractor')->where('id',$id)->first();
		
		if(!empty($contractor)) $name = $contractor->name;
		
		else $name = "NA";
		
		return $name;
	}
}
