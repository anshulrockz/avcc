<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TDSregister;

class TDSregisterController extends Controller
{
    public function __construct()
    {
		$this->TDSregister = new TDSregister();
    }
    public function index()
    {
		$tds = $this->TDSregister->tds_list();
		$count = $tds->count();
		return view('TDSregister/list',['tds'=>$tds,'count'=>$count]);
    }
    public function search(Request $request)
    {
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$this->validate($request,[
			'from_date'=>'required|date',
			'to_date'=>'required|date'
		]);
		$tds = $this->TDSregister->tds_search($from_date,$to_date);
		$count = $tds->count();
		return view('TDSregister/list',['tds'=>$tds,'count'=>$count]);
    }
}
