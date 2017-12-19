<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Accounthead extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function accounthead_list()
	{
		return DB::table('accounthead')->where('status','1')->get();
	}
	public function getAccountheadName($id)
	{
		$accounthead = DB::table('accounthead')->where('id',$id)->get();
		foreach($accounthead as $value){
			$name = $value->name;
		}
		return $name;
	}
    public function accounthead_add($name,$op_balance,$opbalance_date)
    {
		$user_id = Auth::id();
		$opbalance_date = date_format(date_create($opbalance_date),"Y-m-d");
		$accounthead_id = DB::table('accounthead')->insertGetId(
		    ['name' => $name,'op_balance' => $op_balance,'opbalance_date' => $opbalance_date,'created_at' => $this->date,'created_by' => $user_id]
		);
		return $accounthead_id;
    }
	public function accounthead_edit($id)
	{
		return DB::table('accounthead')->where('id',$id)->get();
	}
	public function accounthead_update($id,$name,$op_balance,$opbalance_date)
    {
		$user_id = Auth::id();
		$opbalance_date = date_format(date_create($opbalance_date),"Y-m-d");
		return DB::table('accounthead')
            ->where('id', $id)
            ->update(['name' => $name,'op_balance' => $op_balance,'opbalance_date' => $opbalance_date,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function accounthead_delete($id)
	{
		$user_id = Auth::id();
		$accounthead = DB::table('accounthead')->where('id',$id)->get();
		foreach($accounthead as $value){
			$name = $value->name;
			$op_balance = $value->op_balance;
			$opbalance_date = $value->opbalance_date;
		}
		return DB::table('accounthead')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
