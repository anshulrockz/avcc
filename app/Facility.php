<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Facility extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    public function facility_list()
	{
		return DB::table('facility')->where('status','1')->get();
	}
	public function tax_list($id)
	{
		return DB::table('facilitytax')
			->select('facilitytax.*','tax.name as tax_name')
			->where([
			    ['facilitytax.status', '1'],
			    ['tax.status', '1'],
			    ['facility_id', $id]
			])
            ->leftJoin('tax', 'facilitytax.tax_id', '=', 'tax.id')
            ->get();
	}
    public function facility_add($facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges)
    {
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges) {
			    $facility_id = DB::table('facility')->insertGetId(
				    ['facilitytype_id' => $facility_type,'name' => $name,'sac_code' => $sac_code,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_servicetax' => $rebate_servicetax,'rebate_vat' => $rebate_vat,'rebate_electricity' => $rebate_electricity,'created_at' => $this->date,'created_by' => $user_id]
				);
				for ($i = 0; $i < count($taxes); ++$i) {
					$new_tax = $taxes[$i];
					if($new_tax!=''){
						DB::table('facilitytax')->insert(
							['facility_id' => $facility_id,'tax_id' => $new_tax,'status' => '1']
						);
					}
				}
				if(count($taxes)>0){
					$tax_ids = implode(",",$taxes);
				}
				else{
					$tax_ids = '';
				}
				for ($i = 0; $i < count($member_type); ++$i) {
					$member_type1 = $member_type[$i];
					$booking_rate1 = $booking_rate[$i];
					$generator_charges1 = $generator_charges[$i];
					$ac_charges1 = $ac_charges[$i];
					$safai_general1 = $safai_general[$i];
					$security_charges1 = $security_charges[$i];
					if($member_type1!=''){
						$facilitybookingrate_id = DB::table('facilitybookingrate')->insertGetId(
							['facility_id' => $facility_id,'membertype_id' => $member_type1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'ac_charges' => $ac_charges1,'safai_general' => $safai_general1,'security_charges' => $security_charges1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
						);
					}
				}
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
    }
    public function facilitytype_name($id)
	{
		return DB::table('facility')
			->select('facilitytype.name as facility_type')
			->where('facility.id',$id)
            ->leftJoin('facilitytype', 'facility.facilitytype_id', '=', 'facilitytype.id')
            ->get();
	}
	public function booking_rate($id)
	{
		return DB::table('facilitybookingrate')
			->select('facilitybookingrate.*','membertype.name as member_type')
			->where([['facilitybookingrate.facility_id',$id],['facilitybookingrate.status','1']])
            ->leftJoin('membertype', 'facilitybookingrate.membertype_id', '=', 'membertype.id')
            ->get();
	}
	public function facility_edit($id)
	{
		return DB::table('facility')->where('id',$id)->get();
	}
	public function facility_update($id,$facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges)
    {
		$user_id = Auth::id();
		try{
			DB::transaction(function () use ($user_id,$id,$facility_type,$name,$sac_code,$taxes,$rebate_safai,$rebate_tentage,$rebate_catering,$rebate_servicetax,$rebate_vat,$rebate_electricity,$member_type,$booking_rate,$generator_charges,$ac_charges,$safai_general,$security_charges) {
			    DB::table('facility')
		            ->where('id', $id)
		            ->update(['facilitytype_id' => $facility_type,'name' => $name,'sac_code' => $sac_code,'rebate_safai' => $rebate_safai,'rebate_tentage' => $rebate_tentage,'rebate_catering' => $rebate_catering,'rebate_servicetax' => $rebate_servicetax,'rebate_vat' => $rebate_vat,'rebate_electricity' => $rebate_electricity,'updated_at' => $this->date,'updated_by' => $user_id]);
		        DB::table('facilitytax')
		            ->where('facility_id', $id)
		            ->update(['status' => '0']);
		        for ($i = 0; $i < count($taxes); ++$i) {
					$new_tax = $taxes[$i];
					if($new_tax!=''){
						DB::table('facilitytax')->insert(
							['facility_id' => $id,'tax_id' => $new_tax,'status' => '1']
						);
					}
				}
				if(count($taxes)>0){
					$tax_ids = implode(",",$taxes);
				}
				else{
					$tax_ids = '';
				}
		        DB::table('facilitybookingrate')
		            ->where('facility_id', $id)
		            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
		        for ($i = 0; $i < count($member_type); ++$i) {
					$member_type1 = $member_type[$i];
					$booking_rate1 = $booking_rate[$i];
					$generator_charges1 = $generator_charges[$i];
					$ac_charges1 = $ac_charges[$i];
					$safai_general1 = $safai_general[$i];
					$security_charges1 = $security_charges[$i];
					if($member_type1!=''){
						$facilitybookingrate_id = DB::table('facilitybookingrate')->insertGetId(
							['facility_id' => $id,'membertype_id' => $member_type1,'booking_rate' => $booking_rate1,'generator_charges' => $generator_charges1,'ac_charges' => $ac_charges1,'safai_general' => $safai_general1,'security_charges' => $security_charges1,'created_at' => $this->date,'created_by' => $user_id,'status' => '1']
						);
					}
				}
			});
			return TRUE;
		}
		catch ( \Exception $e ){
			return FALSE;
		}
    }
    public function facility_delete($id)
	{
		$user_id = Auth::id();
		$facility = DB::table('facility')->where('id',$id)->get();
		foreach($facility as $value){
			$facility_type = $value->facilitytype_id;
			$name = $value->name;
			$description = $value->description;
			$rebate_safai = $value->rebate_safai;
			$rebate_tentage = $value->rebate_tentage;
			$rebate_catering = $value->rebate_catering;
			$rebate_servicetax = $value->rebate_servicetax;
			$rebate_vat = $value->rebate_vat;
			$rebate_electricity = $value->rebate_electricity;
		}
		return DB::table('facility')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
