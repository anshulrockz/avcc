<?php
if (! function_exists('record_exists')) {
    function record_exists($input,$column,$table,$id=null){
		$record = DB::table($table)
			->where([
			['status','1'],
			['id','!=',$id],
			[$column,$input]
			])
            ->get();
        $count = $record->count();
        if($count>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
if (! function_exists('facility_cgst')) {
    function facility_cgst($facility_id){
		$record = DB::table('facilitytax')
			->select('tax.percentage')
			->where([
			['facilitytax.status','1'],
			['facilitytax.facility_id',$facility_id],
			['facilitytax.tax_id','1'],
			])
			->leftJoin('tax', 'tax.id', '=', 'facilitytax.tax_id')
            ->first();
        $count = count($record);
        if($count == 0){
			return '0';
		}
		else{
			return $record->percentage;
		}
	}
}
if (! function_exists('facility_sgst')) {
    function facility_sgst($facility_id){
		$record = DB::table('facilitytax')
			->select('tax.percentage')
			->where([
			['facilitytax.status','1'],
			['facilitytax.facility_id',$facility_id],
			['facilitytax.tax_id','2'],
			])
			->leftJoin('tax', 'tax.id', '=', 'facilitytax.tax_id')
            ->first();
        $count = count($record);
        if($count == 0){
			return '0';
		}
		else{
			return $record->percentage;
		}
	}
}
if (! function_exists('post_api')) {
    function post_api($data){
		$data_string = json_encode($data);
		$ch = curl_init(config('app.apiurl'));                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                             
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
}
if (! function_exists('am_pm')) {
    function am_pm($time){
		if($time == ''){
			return '';
		}
		else{
			$new_time = new DateTime($time);
			return $new_time->format('h:i A');
		}
	}
}
if (! function_exists('slash_second')) {
    function slash_second($time){
		if($time == ''){
			return '';
		}
		else{
			$new_time = new DateTime($time);
			return $new_time->format('H:i');
		}
	}
}
if (! function_exists('date_dfy')) {
    function date_dfy($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"d-F-Y");
		}
	}
}
if (! function_exists('date_dmy')) {
    function date_dmy($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"d/m/Y");
		}
	}
}
if (! function_exists('date_ymd')) {
    function date_ymd($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"Y-m-d");
		}
	}
}
if (! function_exists('dateRange_custom')) {
    function dateRange_custom($first, $last, $step = '+1 day', $format = 'Y-m-d'){
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );

		while( $current <= $last ) {

			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}

		return $dates;
	}
}
if (! function_exists('zero_empty')) {
    function zero_empty($data){
		if($data == '0'){
			return '';
		}
		else{
			return $data;
		}
	}
}
if (! function_exists('slash_decimal')) {
    function slash_decimal($data){
		$intdiscount = intval($data);
		$floatdiscount = floatval($data);
		if($intdiscount == $floatdiscount){
			return $intdiscount;
		}
		else{
			return $floatdiscount;
		}
	}
}
if (! function_exists('in_decimal')) {
    function in_decimal($data){
		return number_format((float)$data, 2, '.', '');
	}
}
if (! function_exists('age')) {
    function age($dob){
    	return date_diff(date_create($dob), date_create('today'))->y;
	}
}
if (! function_exists('percent_amount')) {
    function percent_amount($percent,$amount){
    	return$amount*$percent/100;
	}
}
?>