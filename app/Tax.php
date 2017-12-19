<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Tax extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function tax_list()
	{
		return DB::table('tax')->where('status','1')->get();
	}
    public function tax_add($name,$description,$rate,$effective_from)
    {
		$user_id = Auth::id();
		$effective_from = date_format(date_create($effective_from),"Y-m-d");
		return $tax_id = DB::table('tax')->insertGetId(
		    ['name' => $name,'description' => $description,'rate' => $rate,'effective_from' => $effective_from,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function tax_edit($id)
	{
		return DB::table('tax')->where('id',$id)->get();
	}
	public function tax_update($id,$name,$description,$rate,$effective_from)
    {
		$user_id = Auth::id();
		$effective_from = date_format(date_create($effective_from),"Y-m-d");
		return DB::table('tax')
            ->where('id', $id)
            ->update(['name' => $name,'description' => $description,'rate' => $rate,'effective_from' => $effective_from,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function tax_delete($id)
	{
		$user_id = Auth::id();
		$tax = DB::table('tax')->where('id',$id)->get();
		foreach($tax as $value){
			$name = $value->name;
			$description = $value->description;
			$rate = $value->rate;
			$effective_from = $value->effective_from;
		}
		return DB::table('tax')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
