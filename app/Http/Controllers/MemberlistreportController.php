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

class MemberlistreportController extends Controller
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
		return view('memberlistreport/list',['member'=>$member,'count'=>$count,'member_type'=>$member_type,'membertype_name'=>'','sector'=>'']);
    }
    public function search(Request $request)
    {
		$membertype_id = $request->input('member_type');
		$membertype_name = $this->memberlistreport->membertype_name($membertype_id);
		$sector = $request->input('sector');
		$member = $this->memberlistreport->member_search($membertype_id,$sector);
		$count = $member->count();
		$member_type = $this->membertype->membertype_list();
		return view('memberlistreport/list',['member'=>$member,'count'=>$count,'member_type'=>$member_type,'membertype_name'=>$membertype_name,'sector'=>$sector]);
    }
}
