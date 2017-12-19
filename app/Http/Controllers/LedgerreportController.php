<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Memberlistreport;
use App\Member;
use App\Membertype;

class LedgerreportController extends Controller
{
    public function __construct()
    {
		$this->memberlistreport = new Memberlistreport();
		$this->member = new Member();
		$this->membertype = new Membertype();
    }
    public function index()
    {
		$member = $this->memberlistreport->member_list();
		$count = $member->count();
		$member_type = $this->membertype->membertype_list();
		return view('ledgerreport/list',['member'=>$member,'count'=>$count,'member_type'=>$member_type]);
    }
}
