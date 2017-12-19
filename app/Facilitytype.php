<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Facilitytype extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function facilitytype_list()
	{
		return DB::table('facilitytype')->where('status','1')->get();
	}
    public function facilitytype_add($name,$description)
    {
		$user_id = Auth::id();
		return $facilitytype = DB::table('facilitytype')->insertGetId(
		    ['name' => $name,'description' => $description,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function facilitytype_edit($id)
	{
		return DB::table('facilitytype')->where('id',$id)->get();
	}
	public function facilitytype_update($id,$name,$description)
    {
		$user_id = Auth::id();
		return DB::table('facilitytype')
            ->where('id', $id)
            ->update(['name' => $name,'description' => $description,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function facilitytype_delete($id)
	{
		$user_id = Auth::id();
		$facilitytype = DB::table('facilitytype')->where('id',$id)->get();
		foreach($facilitytype as $value){
			$name = $value->name;
			$description = $value->description;
		}
		return DB::table('facilitytype')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
