<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Accounthead;

class AccountheadController extends Controller
{
    public function __construct()
    {
		$this->accounthead = new Accounthead();
    }
    public function index()
    {
		$accounthead = $this->accounthead->accounthead_list();
		$count = $accounthead->count();
		return view('accounthead/list',['accounthead'=>$accounthead,'count'=>$count]);
    }
    public function add()
    {
		return view('accounthead/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$op_balance = $request->input('op_balance');
		$opbalance_date = $request->input('opbalance_date');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','accounthead');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->accounthead->accounthead_add($name,$op_balance,$opbalance_date);
			if($result){
				$request->session()->flash('success', 'Record added successfully!');
			}
			else{
				$request->session()->flash('error', 'Something went wrong!');
			}
		}
		return redirect()->back();
    }
    public function edit($id)
    {
		$accounthead = $this->accounthead->accounthead_edit($id);
		return view('accounthead/edit',['accounthead'=>$accounthead]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$op_balance = $request->input('op_balance');
		$opbalance_date = $request->input('opbalance_date');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','accounthead',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->accounthead->accounthead_update($id,$name,$op_balance,$opbalance_date);
			if($result){
				$request->session()->flash('success', 'Record updated successfully!');
			}
			else{
				$request->session()->flash('error', 'Something went wrong!');
			}
		}
		return redirect()->back();
    }
    public function delete(Request $request,$id)
    {
		$result = $this->accounthead->accounthead_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
