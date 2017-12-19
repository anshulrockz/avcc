<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Bank extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function bank_list()
	{
		return DB::table('bank')->where('status','1')->get();
	}
    public function bank_add($name,$ifsc,$account_no,$address1,$address2,$address3,$city,$contact_person)
    {
		$user_id = Auth::id();
		return $bank_id = DB::table('bank')->insertGetId(
		    ['name' => $name,'ifsc' => $ifsc,'account_no' => $account_no,'address1' => $address1,'address2' => $address2,'address3' => $address3,'city' => $city,'contact_person' => $contact_person,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function bank_edit($id)
	{
		return DB::table('bank')->where('id',$id)->get();
	}
	public function bank_update($id,$name,$ifsc,$account_no,$address1,$address2,$address3,$city,$contact_person)
    {
		$user_id = Auth::id();
		return DB::table('bank')
            ->where('id', $id)
            ->update(['name' => $name,'ifsc' => $ifsc,'account_no' => $account_no,'address1' => $address1,'address2' => $address2,'address3' => $address3,'city' => $city,'contact_person' => $contact_person,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function bank_delete($id)
	{
		$user_id = Auth::id();
		$bank = DB::table('bank')->where('id',$id)->get();
		foreach($bank as $value){
			$name = $value->name;
			$ifsc = $value->ifsc;
			$account_no = $value->account_no;
			$address1 = $value->address1;
			$address2 = $value->address2;
			$address3 = $value->address3;
			$city = $value->city;
			$contact_person = $value->contact_person;
		}
		return DB::table('bank')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
