<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Memberlistreport extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function member_list()
	{
		return DB::table('member')
		->select('member.*','membertype.name as membertype_name')
		->where('member.status','1')
		->leftJoin('membertype','member.member_type', 'membertype.id')
		->get();
	}
	public function membertype_name($membertype_id)
	{
		$membertype_name = '';
		if(!empty($membertype_id)){
			$membertype = DB::table('membertype')
			->where([
				['status','1'],
				['id',$membertype_id]
			])
			->get();
			foreach($membertype as $value){
				$membertype_name = $value->name;
			}
		}
		return $membertype_name;
	}
	public function member_search($membertype_id,$sector)
	{
		
		$filter1 = array();
		$filter2 = array();
		
		if(!empty($membertype_id)){
			$filter1 = array("member_type"=>$membertype_id);
		}
		if(!empty($sector)){
			$filter2 = array("sector"=>$sector);
		}
		
		$filter = array_merge($filter1,$filter2);
		
		return DB::table('member')
		->select('member.*','membertype.name as membertype_name')
		->where($filter)
		->leftJoin('membertype','member.member_type', 'membertype.id')
		->get();
	}
}
