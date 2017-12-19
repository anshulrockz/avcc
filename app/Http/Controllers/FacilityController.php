<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Facilitytype;
use App\Membertype;
use App\Tax;

class FacilityController extends Controller
{
    public function __construct()
    {
		$this->facility = new Facility();
		$this->facilitytype = new Facilitytype();
		$this->membertype = new Membertype();
		$this->tax = new Tax();
    }
    public function index()
    {
		$facility = $this->facility->facility_list();
		$count = $facility->count();
		return view('facility/list',['facility'=>$facility,'count'=>$count]);
    }
    public function add()
    {
		$facilitytype = $this->facilitytype->facilitytype_list();
		$membertype = $this->membertype->membertype_list();
		$tax = $this->tax->tax_list();
		return view('facility/add',['facilitytype'=>$facilitytype,'membertype'=>$membertype,'tax'=>$tax]);
    }
    public function save(Request $request)
    {
		$facility_type = $request->input('facility_type');
		$name = $request->input('name');
		$sac_code = $request->input('sac_code');
		$taxes = $request->input('taxes');
		$rebate_safai = $request->input('rebate_safai');
		$rebate_tentage = $request->input('rebate_tentage');
		$rebate_catering = $request->input('rebate_catering');
		$rebate_servicetax = $request->input('rebate_servicetax');
		$rebate_vat = $request->input('rebate_vat');
		$rebate_electricity = $request->input('rebate_electricity');
		$member_type = $request->input('member_type');
		$booking_rate = $request->input('booking_rate');
		$generator_charges = $request->input('generator_charges');
		$ac_charges = $request->input('ac_charges');
		$safai_general = $request->input('safai_general');
		$security_charges = $request->input('security_charges');
		$this->validate($request,[
			'facility_type'=>'required',
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','facility');
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->facility->facility_add($facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges);
			if($result){
				$request->session()->flash('success', 'Record added successfully!');
			}
			else{
				$request->session()->flash('error', 'Something went wrong!');
			}
		}
		return redirect()->back();
    }
    public function view($id)
    {
		$facility = $this->facility->facility_edit($id);
		$facilitytype = $this->facility->facilitytype_name($id);
		$booking_rate = $this->facility->booking_rate($id);
		$facility_tax = $this->facility->tax_list($id);
		return view('facility/view',['facility'=>$facility,'facilitytype'=>$facilitytype,'booking_rate'=>$booking_rate,'facility_tax'=>$facility_tax]);
    }
    public function edit($id)
    {
		$facility = $this->facility->facility_edit($id);
		$facilitytype = $this->facilitytype->facilitytype_list();
		$membertype = $this->membertype->membertype_list();
		$booking_rate = $this->facility->booking_rate($id);
		$tax = $this->tax->tax_list();
		$facility_tax = $this->facility->tax_list($id);
		return view('facility/edit',['facility'=>$facility,'facilitytype'=>$facilitytype,'membertype'=>$membertype,'booking_rate'=>$booking_rate,'tax'=>$tax,'facility_tax'=>$facility_tax]);
    }
    public function update(Request $request,$id)
    {
		$facility_type = $request->input('facility_type');
		$name = $request->input('name');
		$sac_code = $request->input('sac_code');
		$taxes = $request->input('taxes');
		$rebate_safai = $request->input('rebate_safai');
		$rebate_tentage = $request->input('rebate_tentage');
		$rebate_catering = $request->input('rebate_catering');
		$rebate_servicetax = $request->input('rebate_servicetax');
		$rebate_vat = $request->input('rebate_vat');
		$rebate_electricity = $request->input('rebate_electricity');
		$member_type = $request->input('member_type');
		$booking_rate = $request->input('booking_rate');
		$generator_charges = $request->input('generator_charges');
		$ac_charges = $request->input('ac_charges');
		$safai_general = $request->input('safai_general');
		$security_charges = $request->input('security_charges');
		$this->validate($request,[
			'facility_type'=>'required',
			'name'=>'required'
		]);
		$record_exists = record_exists($name,'name','facility',$id);
		if($record_exists){
			$request->session()->flash('warning', 'Record already exists!');
		}
		else{
			$result = $this->facility->facility_update($id,$facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges);
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
		$result = $this->facility->facility_delete($id);
		if($result){
			$request->session()->flash('success', 'Record deleted successfully!');
		}
		else{
			$request->session()->flash('error', 'Something went wrong!');
		}
		return redirect()->back();
    }
}
