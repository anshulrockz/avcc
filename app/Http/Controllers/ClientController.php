<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Company;

class ClientController extends Controller
{
    public function __construct()
    {
		$this->client = new Client();
		$this->company = new Company();
    }
    public function index()
    {
		$client = $this->client->client_list();
		$count = $client->count();
		return view('client/list',['client'=>$client,'count'=>$count]);
    }
    public function add()
    {
		$company = $this->company->company_list();
		return view('client/add',['company'=>$company]);
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
		$result = $this->client->client_add($company,$name,$address,$phone,$mobile);
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
		$client = $this->client->client_edit($id);
		$company = $this->company->company_list();
		return view('client/edit',['client'=>$client,'company'=>$company]);
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
		$result = $this->client->client_update($id,$company,$name,$address,$phone,$mobile);
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
		$result = $this->client->client_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
