<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Membertype extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function membertype_list()
	{
		return DB::table('membertype')->where('status','1')->get();
	}
    public function membertype_add($name,$description)
    {
		$user_id = Auth::id();
		return $membertype = DB::table('membertype')->insertGetId(
		    ['name' => $name,'description' => $description,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function membertype_edit($id)
	{
		return DB::table('membertype')->where('id',$id)->get();
	}
	public function membertype_update($id,$name,$description)
    {
		$user_id = Auth::id();
		return DB::table('membertype')
            ->where('id', $id)
            ->update(['name' => $name,'description' => $description,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function membertype_delete($id)
	{
		$user_id = Auth::id();
		$membertype = DB::table('membertype')->where('id',$id)->get();
		foreach($membertype as $value){
			$name = $value->name;
			$description = $value->description;
		}
		return DB::table('membertype')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
