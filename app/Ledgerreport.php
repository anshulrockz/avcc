<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Ledgerreport extends Model
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
}
