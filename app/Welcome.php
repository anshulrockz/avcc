<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Welcome extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function members_joined()
    {
		$members_joined = DB::table('member')
			->where('status','1')
            ->get();
        return $members_joined->count();
    }
    public function membersjoined_yesterday()
    {
		$yesterday = Carbon::yesterday();
		$membersjoined_yesterday = DB::table('member')
			->where('status','1')
			->whereDate('created_at',$yesterday)
            ->get();
        return $membersjoined_yesterday->count();
    }
    public function membersjoined_thisweek()
    {
		$yesterday = Carbon::yesterday();
		$monday = Carbon::now()->startOfWeek();
		$sunday = Carbon::now()->endOfWeek();
		$membersjoined_thisweek = DB::table('member')
			->where('status','1')
			->whereBetween('created_at', [$monday, $sunday])
            ->get();
        return $membersjoined_thisweek->count();
    }
    public function booking_done()
    {
		$booking_done = DB::table('booking')
			->where('status','1')
            ->get();
        return $booking_done->count();
    }
    public function bookingdone_yesterday()
    {
		$yesterday = Carbon::yesterday();
		$bookingdone_yesterday = DB::table('booking')
			->where('status','1')
			->whereDate('created_at',$yesterday)
            ->get();
        return $bookingdone_yesterday->count();
    }
    public function bookingdone_thisweek()
    {
		$yesterday = Carbon::yesterday();
		$monday = Carbon::now()->startOfWeek();
		$sunday = Carbon::now()->endOfWeek();
		$bookingdone_thisweek = DB::table('booking')
			->where('status','1')
			->whereBetween('created_at', [$monday, $sunday])
            ->get();
        return $bookingdone_thisweek->count();
    }
    public function receipt_created()
    {
		$receipt_created = DB::table('receipt')
			->where('status','1')
            ->get();
        return $receipt_created->count();
    }
    public function receiptcreated_yesterday()
    {
		$yesterday = Carbon::yesterday();
		$receiptcreated_yesterday = DB::table('receipt')
			->where('status','1')
			->whereDate('created_at',$yesterday)
            ->get();
        return $receiptcreated_yesterday->count();
    }
    public function receiptcreated_thisweek()
    {
		$yesterday = Carbon::yesterday();
		$monday = Carbon::now()->startOfWeek();
		$sunday = Carbon::now()->endOfWeek();
		$receiptcreated_thisweek = DB::table('receipt')
			->where('status','1')
			->whereBetween('created_at', [$monday, $sunday])
            ->get();
        return $receiptcreated_thisweek->count();
    }
    public function latest_members()
    {
		return DB::table('member')
			->select('member.*','membertype.name as membertype_name')
			->where('member.status','1')
			->leftJoin('membertype', 'membertype.id', '=', 'member.member_type')
            ->orderBy('member.id', 'desc')
            ->limit(5)
            ->get();
    }
    public function latest_bookings()
    {
		return DB::table('booking')
			->where('status','1')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
    }
}
