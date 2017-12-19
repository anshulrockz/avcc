<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use App\Company;
use App\Tax;

class ItemController extends Controller
{
    public function __construct()
    {
		$this->item = new Item();
		$this->company = new Company();
		$this->tax = new Tax();
    }
    public function index()
    {
		$item = $this->item->item_list2();
		$count = $item->count();
		return view('item/list',['item'=>$item,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		$tax = $this->tax->tax_list();
		return view('item/add',['company'=>$company,'tax'=>$tax]);
    }
    public function save(Request $request)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$price = $request->input('price');
		$category = $request->input('category');
		$unit = $request->input('unit');
		$taxes = $request->input('taxes');
		$this->validate($request,[
			'company'=>'required',
			'name'=>'required',
			'price'=>'required',
			'category'=>'required',
			'unit'=>'required'
		]);
		$result = $this->item->item_add($company,$name,$description,$price,$category,$unit,$taxes);
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
		$item = $this->item->item_edit($id);
		$company = $this->company->company_list();
		$category = $this->item->category_list($id);
		$unit = $this->item->unit_list($id);
		$tax = $this->tax->tax_list();
		$item_tax = $this->item->tax_list($id);
		return view('item/edit',['item'=>$item,'company'=>$company,'category'=>$category,'unit'=>$unit,'tax'=>$tax,'item_tax'=>$item_tax]);
    }
    public function update(Request $request,$id)
    {
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$price = $request->input('price');
		$category = $request->input('category');
		$unit = $request->input('unit');
		$taxes = $request->input('taxes');
		$this->validate($request,[
			'company'=>'required',
			'name'=>'required',
			'price'=>'required',
			'category'=>'required',
			'unit'=>'required'
		]);
		$result = $this->item->item_update($id,$company,$name,$description,$price,$category,$unit,$taxes);
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
		$result = $this->item->item_delete($id);
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
		$this->item->ajax($company_id);
    }
}
