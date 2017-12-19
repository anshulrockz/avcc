<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;

class CompanyController extends Controller
{
    public function __construct()
    {
		$this->company = new Company();
    }
    public function index()
    {
		$company = $this->company->company_list();
		$count = $company->count();
		return view('company/list',['company'=>$company,'count'=>$count]);
    }
    public function add()
    {
		return view('company/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$address = $request->input('address');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$this->validate($request,[
			'name'=>'required',
			'address'=>'required'
		]);
		$result = $this->company->company_add($name,$address,$phone,$mobile);
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
		$company = $this->company->company_edit($id);
		return view('company/edit',['company'=>$company]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$address = $request->input('address');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$this->validate($request,[
			'name'=>'required',
			'address'=>'required'
		]);
		$result = $this->company->company_update($id,$name,$address,$phone,$mobile);
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
		$result = $this->company->company_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
