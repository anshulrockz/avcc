<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use Excel;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member;
use App\Membertype;

class MemberController extends Controller
{
    public function __construct()
    {
		$this->member = new Member();
		$this->membertype = new Membertype();
    }
    public function index()
    {
		return view('member/list');
    }
    public function members()
    {
		$member = $this->member->member_list();
        return Datatables::of($member)
        ->addColumn('action', function ($member) {
                return '<a href="member/edit/'.$member->id.'" data-toggle="tooltip" title="Edit" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                <a onclick="return confirm('."'Are you sure you want to Delete?'".');" href="member/delete/'.$member->id.'" data-toggle="tooltip" title="Delete" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
            })
        ->make(true);
    }
    public function downloadMember($type)
	{
		$member = $this->member->export_member_list();
		$data= json_decode( json_encode($member), true);
		return Excel::create('avcc_members', function($excel) use ($data) {
			$excel->sheet('First Sheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);

	        });
		})->export($type);
	}
    public function add()
    {
		$membertype = $this->membertype->membertype_list();
		return view('member/add',['membertype'=>$membertype]);
    }
    public function save(Request $request)
    {
		$membership_no = $request->input('membership_no');
		$member_type = $request->input('member_type');
		$name = $request->input('name');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$email = $request->input('email');
		$expiry_date = $request->input('expiry_date');
		$sex = $request->input('sex');
		$address = $request->input('address');
		$sector = $request->input('sector');
		$city = $request->input('city');
		$opsec_amt = $request->input('opsec_amt');
		$opsecamt_date = $request->input('opsecamt_date');
		$this->validate($request,[
			'membership_no'=>'required',
			'member_type'=>'required',
			'name'=>'required',
			'sex'=>'required',
			'address'=>'required',
			'sector'=>'required',
			'city'=>'required'
		]);
		$record_exists = record_exists($mobile,'mobile','member');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->member->member_add($membership_no,$member_type,$name,$phone,$mobile,$email,$expiry_date,$sex,$address,$sector,$city,$opsec_amt,$opsecamt_date);
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
		$member = $this->member->member_edit($id);
		$membertype = $this->membertype->membertype_list();
		return view('member/edit',['member'=>$member,'membertype'=>$membertype]);
    }
    public function update(Request $request,$id)
    {
		$membership_no = $request->input('membership_no');
		$member_type = $request->input('member_type');
		$name = $request->input('name');
		$phone = $request->input('phone');
		$mobile = $request->input('mobile');
		$email = $request->input('email');
		$expiry_date = $request->input('expiry_date');
		$sex = $request->input('sex');
		$address = $request->input('address');
		$sector = $request->input('sector');
		$city = $request->input('city');
		$opsec_amt = $request->input('opsec_amt');
		$opsecamt_date = $request->input('opsecamt_date');
		$this->validate($request,[
			'membership_no'=>'required',
			'member_type'=>'required',
			'name'=>'required',
			'sex'=>'required',
			'address'=>'required',
			'sector'=>'required',
			'city'=>'required'
		]);
		$record_exists = record_exists($mobile,'mobile','member',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->member->member_update($id,$membership_no,$member_type,$name,$phone,$mobile,$email,$expiry_date,$sex,$address,$sector,$city,$opsec_amt,$opsecamt_date);
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
		$result = $this->member->member_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
