<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Rebateregister;

class RebateregisterController extends Controller
{
    public function __construct()
    {
		$this->rebate = new Rebateregister();
    }
    public function index()
    {
		$rebate = $this->rebate->rebate_list();
		$count = $rebate->count();
		//print_r($rebate);
		return view('rebateregister/list',['rebate'=>$rebate,'count'=>$count,'rebate_register'=>$this->rebate]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$rebate = $this->rebate->rebate_search($from_date,$to_date);
		$count = $rebate->count();
		return view('rebateregister/list',['rebate'=>$rebate,'count'=>$count,'rebate_register'=>$this->rebate]);
    }
}
