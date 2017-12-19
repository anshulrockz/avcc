<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Openingstock;
use App\Company;

class OpeningstockController extends Controller
{
    public function __construct()
    {
		$this->openingstock = new Openingstock();
		$this->company = new Company();
    }
    public function index()
    {
		$openingstock = $this->openingstock->openingstock_list();
		$count = $openingstock->count();
		return view('openingstock/list',['openingstock'=>$openingstock,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		return view('openingstock/add',['company'=>$company]);
    }
    public function save(Request $request)
    {
		$company = $request->input('company');
		$category = $request->input('category');
		$item = $request->input('item');
		$quantity = $request->input('quantity');
		$rate = $request->input('rate');
		$on_date = $request->input('on_date');
		$this->validate($request,[
			'company'=>'required',
			'category'=>'required',
			'item'=>'required',
			'quantity'=>'required|numeric',
			'rate'=>'required|numeric',
			'on_date'=>'required|date|after:yesterday'
		]);
		$result = $this->openingstock->openingstock_add($company,$item,$quantity,$rate,$on_date);
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
		$openingstock = $this->openingstock->openingstock_edit($id);
		$company = $this->company->company_list();
		foreach($openingstock as $value){
			$item_id = $value->item_id;
		}
		$category = $this->openingstock->category_list($item_id);
		$category_id = $this->openingstock->category_id($item_id);
		$item = $this->openingstock->item_list($category_id);
		return view('openingstock/edit',['openingstock'=>$openingstock,'company'=>$company,'category'=>$category,'category_id'=>$category_id,'item'=>$item]);
    }
    public function update(Request $request,$id)
    {
		$company = $request->input('company');
		$category = $request->input('category');
		$item = $request->input('item');
		$quantity = $request->input('quantity');
		$rate = $request->input('rate');
		$on_date = $request->input('on_date');
		$this->validate($request,[
			'company'=>'required',
			'category'=>'required',
			'item'=>'required',
			'quantity'=>'required|numeric',
			'rate'=>'required|numeric',
			'on_date'=>'required|date|after:yesterday'
		]);
		$result = $this->openingstock->openingstock_update($id,$company,$item,$quantity,$rate,$on_date);
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
		$result = $this->openingstock->openingstock_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function ajax(Request $request)
    {
		$company_id = $request->input('company_id');
		$this->openingstock->ajax($company_id);
    }
    public function ajax2(Request $request)
    {
		$category_id = $request->input('category_id');
		$this->openingstock->ajax2($category_id);
    }
}
