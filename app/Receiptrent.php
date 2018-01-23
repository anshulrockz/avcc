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
		return DB::table('receipt')
		->where([
			['receipt.status','!=','0'],
			['receipt.receipt_type','5'],
			])
		->leftJoin('receipt_rent', 'receipt.id', '=', 'receipt_rent.parent_id')
		->groupBy('receipt.id')
		->orderBy('receipt_rent.id', 'desc')
		->get();
	}
	
    public function receipt_add($party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax,$comments)
    {
		$user_id = Auth::id();
		try{
			$parent_id = DB::transaction(function () use ($user_id,$party_name,$party_gstin,$reverse_charges,$phone,$mobile,$address,$payment_mode,$cheque_no,$cheque_date,$cheque_drawn,$rent_premises,$rent_store,$rent_atm,$tds,$with_tax,$comments) {
				if(!empty($function_date)){
					$function_date = date_format(date_create($function_date),"Y-m-d");
				}
				if(!empty($cheque_date)){
					echo $cheque_date = date_format(date_create($cheque_date),"Y-m-d");
				}
				$parent_id = DB::table('receipt')->insertGetId(
					    ['receipt_type' => 5,'party_name' => $party_name,'party_gstin' => $party_gstin,'reverse_charges' => $reverse_charges,'phone' => $phone,'mobile' => $mobile,'address' => $address,'payment_mode' => $payment_mode,'cheque_no' => $cheque_no,'cheque_date' => $cheque_date,'cheque_drawn' => $cheque_drawn, 'created_at' => $this->date,'created_by' => $user_id,'updated_at' => $this->date,'updated_by' => $user_id,'comments' => $comments]
				);
				
				DB::table('receipt')->where('id', $parent_id)->update(['receipt_no' => $parent_id,]);
				
				DB::table('receipt_rent')->insert(
					    ['parent_id' => $parent_id, 'rent_premises' => $rent_premises,'rent_store' => $rent_store,'rent_atm' => $rent_atm,'tds' => $tds]
				);
				
				if(!empty($with_tax)){
					$tax = DB::table('tax')->where('status', 1)->get();
					
					foreach($tax as $receipt_tax ){
						$tax_name = $receipt_tax->name;
						$tax_percentage = $receipt_tax->percentage;
						
						DB::table('receipt_tax')->insert(
						['parent_id' => $parent_id, 'tax_name' => $tax_name,'tax_percentage' => $tax_percentage]
						);
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
