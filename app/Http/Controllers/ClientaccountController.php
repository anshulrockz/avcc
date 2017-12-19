<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Clientaccount;

class ClientaccountController extends Controller
{
    public function __construct()
    {
		$this->clientaccount = new Clientaccount();
    }
    public function index()
    {
		$clientaccount = $this->clientaccount->clientaccount_list();
		$count = $clientaccount->count();
		return view('clientaccount/list',['clientaccount'=>$clientaccount,'count'=>$count]);
    }
    public function detail($id)
    {
		$clientaccount = $this->clientaccount->clientaccount_detail($id);
		$count = $clientaccount->count();
		$client_name = $this->clientaccount->get_clientname($id);
		return view('clientaccount/detail',['clientaccount'=>$clientaccount,'count'=>$count,'client_name'=>$client_name]);
    }
}
