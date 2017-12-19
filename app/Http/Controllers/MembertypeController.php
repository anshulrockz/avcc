<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Membertype;

class MembertypeController extends Controller
{
    public function __construct()
    {
		$this->membertype = new Membertype();
    }
    public function index()
    {
		$membertype = $this->membertype->membertype_list();
		$count = $membertype->count();
		return view('membertype/list',['membertype'=>$membertype,'count'=>$count]);
    }
    public function add()
    {
		return view('membertype/add');
    }
    public function save(Request $request)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','membertype');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->membertype->membertype_add($name,$description);
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
		$membertype = $this->membertype->membertype_edit($id);
		return view('membertype/edit',['membertype'=>$membertype]);
    }
    public function update(Request $request,$id)
    {
		$name = $request->input('name');
		$description = $request->input('description');
		$this->validate($request,[
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','membertype',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->membertype->membertype_update($id,$name,$description);
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
		$result = $this->membertype->membertype_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
