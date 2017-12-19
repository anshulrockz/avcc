<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bank;

class BankController extends Controller
{
    public function __construct()
    {
		$this->bank = new Bank();
    }
    public function index()
    {
		$bank = $this->bank->bank_list();
		$count = $bank->count();
		return view('bank/list',['bank'=>$bank,'count'=>$count]);
    }
    public function add()
    {
		return view('bank/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$ifsc = $request->input('ifsc');
		$account_no = $request->input('account_no');
		$address1 = $request->input('address1');
		$address2 = $request->input('address2');
		$address3 = $request->input('address3');
		$city = $request->input('city');
		$contact_person = $request->input('contact_person');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($ifsc,'ifsc','bank');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->bank->bank_add($name,$ifsc,$account_no,$address1,$address2,$address3,$city,$contact_person);
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
		$bank = $this->bank->bank_edit($id);
		return view('bank/edit',['bank'=>$bank]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$ifsc = $request->input('ifsc');
		$account_no = $request->input('account_no');
		$address1 = $request->input('address1');
		$address2 = $request->input('address2');
		$address3 = $request->input('address3');
		$city = $request->input('city');
		$contact_person = $request->input('contact_person');
		$this->validate($request,[
			'name'=>'required',
			'ifsc'=>'required',
			'account_no'=>'required',
			'address1'=>'required',
			'city'=>'required'
		]);
		$record_exists = record_exists($ifsc,'ifsc','bank',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->bank->bank_update($id,$name,$ifsc,$account_no,$address1,$address2,$address3,$city,$contact_person);
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
		$result = $this->bank->bank_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
