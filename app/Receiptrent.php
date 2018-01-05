<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Receiptrent extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    
    public function receipt_list()
	{
		return DB::table('receipt_rent')
		->leftJoin('receipt', 'receipt.id', '=', 'receipt_rent.parent_id')
		->orderBy('receipt_rent.id', 'desc')
		->get();
	}
	
	public static function tax_check($parent_id)
	{
		$with_tax = DB::table('receipt_tax')
		->where('parent_id', $parent_id)
		->get()->count();
		return $with_tax;
	}
	
    public function receipt_add($party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax)
    {
		$user_id = Auth::id();
		try{
			$parent_id = DB::transaction(function () use ($user_id,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax) {
				
				$parent_id = DB::table('receipt')->insertGetId(
					    ['receipt_type' => 5,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn, 'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id]]
				);
				
				DB::table('receipt')->where('id', $parent_id)->update(['receipt_no' => $parent_id,]);
				
				$receipt_id = DB::table('receipt_rent')->insertGetId(
					    ['parent_id' => $parent_id, 'rent_premises' => $rent_premises,'rent_store' => $rent_store,'rent_atm' => $rent_atm,'tds' => $tds]
				);
				
				if(!empty($with_tax)){
					$tax = DB::table('tax')->where('status', 1)->get();
					foreach($tax as $receipt_tax ){
						$tax_name = $receipt_tax->name;
						$tax_percentage = $receipt_tax->percentage;
						$receipt_tax_id = DB::table('receipt_tax')->insertGetId(['parent_id' => $parent_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]);
					}
				}
				return $parent_id;
			});
			return $parent_id;
		}
		catch(\Exception $e){
			return FALSE;
		}
    }
}
