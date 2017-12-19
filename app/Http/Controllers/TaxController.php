<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tax;

class TaxController extends Controller
{
    public function __construct()
    {
		$this->tax = new Tax();
    }
    public function index()
    {
		$tax = $this->tax->tax_list();
		$count = $tax->count();
		return view('tax/list',['tax'=>$tax,'count'=>$count]);
    }
    public function add()
    {
		return view('tax/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$rate = $request->input('rate');
		$effective_from = $request->input('effective_from');
		$this->validate($request,[
			'name'=>'required',
			'rate'=>'required',
			'effective_from'=>'date|after:yesterday'
		]);
		$result = $this->tax->tax_add($name,$description,$rate,$effective_from);
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
		$tax = $this->tax->tax_edit($id);
		return view('tax/edit',['tax'=>$tax]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$rate = $request->input('rate');
		$effective_from = $request->input('effective_from');
		$this->validate($request,[
			'name'=>'required',
			'rate'=>'required',
			'effective_from'=>'date|after:yesterday'
		]);
		$result = $this->tax->tax_update($id,$name,$description,$rate,$effective_from);
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
		$result = $this->tax->tax_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
