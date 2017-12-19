<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Debitvoucher;
use App\Accounthead;
use App\Contractor;

class DebitvoucherController extends Controller
{
    public function __construct()
    {
		$this->debitvoucher = new Debitvoucher();
		$this->accounthead = new Accounthead();
		$this->contractor = new Contractor();
    }
    public function index()
    {
		$debitvoucher = $this->debitvoucher->debitvoucher_list();
		$count = $debitvoucher->count();
		return view('debitvoucher/list',['debitvoucher'=>$debitvoucher,'count'=>$count]);
    }
    public function add()
    {
		$debitvoucher = DB::table('debitvoucher')->orderBy('id', 'desc')->first();
		$debitvoucher_id = 0;
		if(!empty($debitvoucher)){
			$debitvoucher_id = $debitvoucher->id;
		}
		$ac_head = $this->accounthead->accounthead_list();
		$paid_to = $this->contractor->contractor_list();
		return view('debitvoucher/add',['voucher_id'=>$debitvoucher_id,'ac_head'=>$ac_head,'paid_to'=>$paid_to]);
    }
    public function save(Request $request)
    {
		$voucher_date = $request->input('voucher_date');
		$rv_no = $request->input('rv_no');
		$rv_date = $request->input('rv_date');
		$party_name = $request->input('party_name');
		$function_date = $request->input('function_date');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$achead_id = $request->input('account_head');
		$paid_to = $request->input('paid_to');
		$security_amount = $request->input('security_amount');
		$remarks = $request->input('remarks');
		
		$this->validate($request,[
			'voucher_date'=>'required|date',
			'rv_no'=>'required',
			'rv_date'=>'required|date',
			'party_name'=>'required',
			'function_date'=>'required|date',
			'cheque_no'=>'required',
			'cheque_date'=>'required|date',
			'account_head'=>'required',
			'paid_to'=>'required',
			'security_amount'=>'required',
			'remarks'=>'required'
		]);
		
		$result = $this->debitvoucher->debitvoucher_add($voucher_date,$rv_no,$rv_date,$party_name,$function_date,$cheque_no,$cheque_date,$achead_id,$paid_to,$security_amount,$remarks);
		if($result){
			$request->session()->flash('success', 'Voucher created successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function view($id)
    {
		$debitvoucher = $this->debitvoucher->debitvoucher_edit($id);
		return view('debitvoucher/view',['voucher'=>$debitvoucher]);
    }
    public function edit($id)
    {
		$debitvoucher = $this->debitvoucher->debitvoucher_edit($id);
		$ac_head = $this->accounthead->accounthead_list();
		$paid_to = $this->contractor->contractor_list();
		return view('debitvoucher/edit',['voucher'=>$debitvoucher,'ac_head'=>$ac_head,'paid_to'=>$paid_to]);
    }
    public function update(Request $request,$id)
    {
		$voucher_date = $request->input('voucher_date');
		$rv_no = $request->input('rv_no');
		$rv_date = $request->input('rv_date');
		$party_name = $request->input('party_name');
		$function_date = $request->input('function_date');
		$cheque_no = $request->input('cheque_no');
		$cheque_date = $request->input('cheque_date');
		$achead_id = $request->input('account_head');
		$paid_to = $request->input('paid_to');
		$security_amount = $request->input('security_amount');
		$remarks = $request->input('remarks');
		
		$this->validate($request,[
			'voucher_date'=>'required|date',
			'rv_no'=>'required',
			'rv_date'=>'required|date',
			'party_name'=>'required',
			'function_date'=>'required|date',
			'cheque_no'=>'required',
			'cheque_date'=>'required|date',
			'account_head'=>'required',
			'paid_to'=>'required',
			'security_amount'=>'required',
			'remarks'=>'required'
		]);
		
		$result = $this->debitvoucher->debitvoucher_update($id,$voucher_date,$rv_no,$rv_date,$party_name,$function_date,$cheque_no,$cheque_date,$achead_id,$paid_to,$security_amount,$remarks);
		if($result){
			$request->session()->flash('success', 'Voucher updated successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
    public function delete(Request $request,$id)
    {
		$result = $this->debitvoucher->debitvoucher_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('failed', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
