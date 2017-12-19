<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facilitytype;

class FacilitytypeController extends Controller
{
    public function __construct()
    {
		$this->facilitytype = new Facilitytype();
    }
    public function index()
    {
		$facilitytype = $this->facilitytype->facilitytype_list();
		$count = $facilitytype->count();
		return view('facilitytype/list',['facilitytype'=>$facilitytype,'count'=>$count]);
    }
    public function add()
    {
		return view('facilitytype/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','facilitytype');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->facilitytype->facilitytype_add($name,$description);
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
		$facilitytype = $this->facilitytype->facilitytype_edit($id);
		return view('facilitytype/edit',['facilitytype'=>$facilitytype]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','facilitytype',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->facilitytype->facilitytype_update($id,$name,$description);
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
		$result = $this->facilitytype->facilitytype_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
