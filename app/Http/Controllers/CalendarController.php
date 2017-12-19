<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Calendar;

class CalendarController extends Controller
{
    public function __construct()
    {
		$this->calendar = new Calendar();
    }
    public function index()
    {
		$booking = $this->calendar->calendar_view();
		return view('calendar/view',['booking'=>$booking]);
    }
}
