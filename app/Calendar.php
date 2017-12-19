<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Calendar extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function calendar_view()
	{
		return DB::table('booking')
				->where([
				['status','1'],
				['booking_status','1'],
				])
				->get();
	}
}

