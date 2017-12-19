<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Member extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function member_list()
	{
		return DB::table('member')
			->select('member.*','membertype.name as membertype_name')
			->leftJoin('membertype', 'member.member_type', '=', 'membertype.id')
			->where('member.status','1')
			->orderBy('member.membership_no', 'asc')
			->get();
	}
	public function export_member_list()
	{
		return DB::table('member')
			->select('member.membership_no as Membership_No','membertype.name as Member_Type','member.name as Name','member.mobile as Mobile','member.email as Email','member.address as Address','member.sector as Sector','member.city as City','member.opsec_amt as Op.Sec_Amount','member.opsecamt_date as Op.Sec_Amount_Date')
			->leftJoin('membertype', 'member.member_type', '=', 'membertype.id')
			->where('member.status','1')
			->orderBy('member.membership_no', 'asc')
			->get();
	}
    public function member_add($membership_no,$member_type,$name,$phone,$mobile,$email,$expiry_date,$sex,$address,$sector,$city,$opsec_amt,$opsecamt_date)
    {
		$user_id = Auth::id();
		$expiry_date = date_format(date_create($expiry_date),"Y-m-d");
		$opsecamt_date = date_format(date_create($opsecamt_date),"Y-m-d");
		return $member_id = DB::table('member')->insertGetId(
		    ['membership_no' => $membership_no,'member_type' => $member_type,'name' => $name,'phone' => $phone,'mobile' => $mobile,'email' => $email,'expiry_date' => $expiry_date,'sex' => $sex,'address' => $address,'sector' => $sector,'city' => $city,'opsec_amt' => $opsec_amt,'opsecamt_date' => $opsecamt_date,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function member_edit($id)
	{
		return DB::table('member')->where('id',$id)->get();
	}
	public function member_update($id,$membership_no,$member_type,$name,$phone,$mobile,$email,$expiry_date,$sex,$address,$sector,$city,$opsec_amt,$opsecamt_date)
    {
		$user_id = Auth::id();
		$expiry_date = date_format(date_create($expiry_date),"Y-m-d");
		$opsecamt_date = date_format(date_create($opsecamt_date),"Y-m-d");
		return DB::table('member')
            ->where('id', $id)
            ->update(['membership_no' => $membership_no,'member_type' => $member_type,'name' => $name,'phone' => $phone,'mobile' => $mobile,'email' => $email,'expiry_date' => $expiry_date,'sex' => $sex,'address' => $address,'sector' => $sector,'city' => $city,'opsec_amt' => $opsec_amt,'opsecamt_date' => $opsecamt_date,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function member_delete($id)
	{
		$user_id = Auth::id();
		$member = DB::table('member')->where('id',$id)->get();
		foreach($member as $value){
			$member_type = $value->member_type;
			$name = $value->name;
			$phone = $value->phone;
			$mobile = $value->mobile;
			$email = $value->email;
			$expiry_date = $value->expiry_date;
			$sex = $value->sex;
			$address = $value->address;
			$sector = $value->sector;
			$city = $value->city;
			$opsec_amt = $value->opsec_amt;
			$opsecamt_date = $value->opsecamt_date;
		}
		return DB::table('member')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
