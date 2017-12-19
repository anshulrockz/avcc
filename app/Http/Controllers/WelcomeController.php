<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Welcome;

class WelcomeController extends Controller
{
    public function __construct()
    {
		$this->dashboard = new Welcome();
    }
    public function index()
    {
		$user = Auth::user();
		$user_id = $user->id;
		$user_name = $user->name;
		
		$members_joined = $this->dashboard->members_joined();
		$membersjoined_yesterday = $this->dashboard->membersjoined_yesterday();
		$membersjoined_thisweek = $this->dashboard->membersjoined_thisweek();
		
		$booking_done = $this->dashboard->booking_done();
		$bookingdone_yesterday = $this->dashboard->bookingdone_yesterday();
		$bookingdone_thisweek = $this->dashboard->bookingdone_thisweek();
		
		$receipt_created = $this->dashboard->receipt_created();
		$receiptcreated_yesterday = $this->dashboard->receiptcreated_yesterday();
		$receiptcreated_thisweek = $this->dashboard->receiptcreated_thisweek();
		
		$latest_members = $this->dashboard->latest_members();
		$latestmembers_count = $latest_members->count();
		
		$latest_bookings = $this->dashboard->latest_bookings();
		$latestbookings_count = $latest_bookings->count();
		
		return view('welcome',['user_id'=>$user_id,'user_name'=>$user_name,'members_joined'=>$members_joined,'membersjoined_yesterday'=>$membersjoined_yesterday,'membersjoined_thisweek'=>$membersjoined_thisweek,'booking_done'=>$booking_done,'bookingdone_yesterday'=>$bookingdone_yesterday,'bookingdone_thisweek'=>$bookingdone_thisweek,'receipt_created'=>$receipt_created,'receiptcreated_yesterday'=>$receiptcreated_yesterday,'receiptcreated_thisweek'=>$receiptcreated_thisweek,'latest_members'=>$latest_members,'latestmembers_count'=>$latestmembers_count,'latest_bookings'=>$latest_bookings,'latestbookings_count'=>$latestbookings_count]);
    }
}
