<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Vendor;
use App\Company;

class VendorController extends Controller
{
    public function __construct()
    {
		$this->vendor = new Vendor();
		$this->company = new Company();
    }
    public function index()
    {
		$vendor = $this->vendor->vendor_list();
		$count = $vendor->count();
		return view('vendor/list',['vendor'=>$vendor,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		return view('vendor/add',['company'=>$company]);
    }
    public function save(Request $request)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$address = $request->input('address');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$this->validate($request,[
			'name'=>'required',
			'address'=>'required',
			'company'=>'required'
		]);
		$result = $this->vendor->vendor_add($company,$name,$address,$phone,$mobile);
		if($result){
			$request->session()->flash('success', 'Record added successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function edit($id)
    {
		$vendor = $this->vendor->vendor_edit($id);
		$company = $this->company->company_list();
		return view('vendor/edit',['vendor'=>$vendor,'company'=>$company]);
    }
    public function update(Request $request,$id)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$address = $request->input('address');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$this->validate($request,[
			'name'=>'required',
			'address'=>'required',
			'company'=>'required'
		]);
		$result = $this->vendor->vendor_update($id,$company,$name,$address,$phone,$mobile);
		if($result){
			$request->session()->flash('success', 'Record updated successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function delete(Request $request,$id)
    {
		$result = $this->vendor->vendor_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
