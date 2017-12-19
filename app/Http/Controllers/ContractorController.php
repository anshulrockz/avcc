<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contractor;

class ContractorController extends Controller
{
    public function __construct()
    {
		$this->contractor = new Contractor();
    }
    public function index()
    {
		$contractor = $this->contractor->contractor_list();
		$count = $contractor->count();
		return view('contractor/list',['contractor'=>$contractor,'count'=>$count]);
    }
    public function add()
    {
		return view('contractor/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address1 = $request->input('address1');
		$address2 = $request->input('address2');
		$address3 = $request->input('address3');
		$op_balance = $request->input('op_balance');
		$opbalance_date = $request->input('opbalance_date');
		$rebate = $request->input('rebate');
		$this->validate($request,[
			'name'=>'required',
			'address1'=>'required'
		]);
		$record_exists = record_exists($name,'name','contractor');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->contractor->contractor_add($name,$phone,$mobile,$address1,$address2,$address3,$op_balance,$opbalance_date,$rebate);
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
		$contractor = $this->contractor->contractor_edit($id);
		return view('contractor/edit',['contractor'=>$contractor]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$address1 = $request->input('address1');
		$address2 = $request->input('address2');
		$address3 = $request->input('address3');
		$op_balance = $request->input('op_balance');
		$opbalance_date = $request->input('opbalance_date');
		$rebate = $request->input('rebate');
		$this->validate($request,[
			'name'=>'required',
			'address1'=>'required'
		]);
		$record_exists = record_exists($name,'name','contractor',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->contractor->contractor_update($id,$name,$phone,$mobile,$address1,$address2,$address3,$op_balance,$opbalance_date,$rebate);
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
		$result = $this->contractor->contractor_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
