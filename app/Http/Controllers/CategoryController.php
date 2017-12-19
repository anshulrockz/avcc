<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Company;

class CategoryController extends Controller
{
    public function __construct()
    {
		$this->category = new Category();
		$this->company = new Company();
    }
    public function index()
    {
		$category = $this->category->category_list();
		$count = $category->count();
		return view('category/list',['category'=>$category,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		$parent = $this->category->category_list();
		return view('category/add',['company'=>$company,'parent'=>$parent]);
    }
    public function save(Request $request)
    {
		$parent = $request->input('parent');
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required',
			'company'=>'required'
		]);
		$result = $this->category->category_add($parent,$company,$name,$description);
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
		$category = $this->category->category_edit($id);
		$company = $this->company->company_list();
		$parent = $this->category->category_list();
		return view('category/edit',['category'=>$category,'company'=>$company,'parent'=>$parent]);
    }
    public function update(Request $request,$id)
    {
		$parent = $request->input('parent');
		$company = $request->input('company');
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required',
			'company'=>'required'
		]);
		$result = $this->category->category_update($id,$parent,$company,$name,$description);
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
		$result = $this->category->category_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
