<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Unit;
use App\Company;

class UnitController extends Controller
{
    public function __construct()
    {
		$this->unit = new Unit();
		$this->company = new Company();
    }
    public function index()
    {
		$unit = $this->unit->unit_list();
		$count = $unit->count();
		return view('unit/list',['unit'=>$unit,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		return view('unit/add',['company'=>$company]);
    }
    public function save(Request $request)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required',
			'company'=>'required'
		]);
		$result = $this->unit->unit_add($company,$name,$description);
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
		$unit = $this->unit->unit_edit($id);
		$company = $this->company->company_list();
		return view('unit/edit',['unit'=>$unit,'company'=>$company]);
    }
    public function update(Request $request,$id)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required',
			'company'=>'required'
		]);
		$result = $this->unit->unit_update($id,$company,$name,$description);
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
		$result = $this->unit->unit_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
