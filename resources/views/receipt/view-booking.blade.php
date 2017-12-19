<?php
//Get Reverse Charges
if($receipt[0]->reverse_charges == '1'){
	$reverse_charges = ($servicetax_total+$receipt[0]->others_amount*$global_st/100)+($vat_total+$receipt[0]->others_amount*$global_vat/100);
//	$global_st = 0;
//	$global_vat = 0;
//	$cgst = 0;
//	$sgst = 0;
}
else{
	$reverse_charges = 0;
}
$cgst = $servicetax_total+$receipt[0]->others_amount*$global_st/100;
$sgst = $vat_total+$receipt[0]->others_amount*$global_vat/100;
// Get Total
$tax = 0;
$others_tax = 0;
$security = 0;
if($receipt[0]->with_tax == '1'){
	$others_tax = $receipt[0]->others_amount*$global_st/100+$receipt[0]->others_amount*$global_vat/100;
	$tax = $servicetax_total+$vat_total;
}
if($receipt[0]->with_security == '1'){
	$security = $security_charges;
}
$total = $sub_total+$receipt[0]->misc_amount+$receipt[0]->others_amount+$tax+$others_tax+$security;

//$cgst = $servicetax_total+$receipt[0]->others_amount*$global_st/100;
//$sgst = $vat_total+$receipt[0]->others_amount*$global_vat/100;

?>
<table class="table table-bordered">
	<tr>
		<th rowspan="2">S.NO</th>
		<th rowspan="2">Particular</th>
		<th rowspan="2">SAC Code</th>
		<th rowspan="2">From Date</th>
		<th rowspan="2">To Date</th>
		<th rowspan="2">Quantity</th>
		<th rowspan="2">No of Days</th>
		<th rowspan="2">Rate</th>
		<th rowspan="2">Amount</th>
		<th colspan="2">CGST</th>
		<th colspan="2">SGST</th>
		<th rowspan="2">Total</th>
	</tr>
	<tr>
		<th>Rate (%)</th>
		<th>Amount</th>
		<th>Rate (%)</th>
		<th>Amount</th>
	</tr>
	@foreach ($booking_facility as $key=>$value)
	<?php
	$amount_before_tax = $value->booking_rate*$value->noofdays*$value->quantity;
	$st_amount = percent_amount(facility_cgst($value->facility_id),$amount_before_tax);
	$vat_amount = percent_amount(facility_sgst($value->facility_id),$amount_before_tax);
	?>
	<tr>
		<td>{{++$key}}</td>
		<td>{{ $value->facility_name }}</td>
		<td>{{ $value->sac_code }}</td>
		<td>{{ date_dmy($value->from_date) }}</td>
		<td>{{ date_dmy($value->to_date) }}</td>
		<td>{{ $value->quantity }}</td>
		<td>{{ $value->noofdays }}</td>
		<td>{{ slash_decimal($value->booking_rate) }}</td>
		<td>{{ $amount_before_tax }}</td>
		<td>{{slash_decimal(facility_cgst($value->facility_id))}}</td>
		<td>{{$st_amount}}</td>
		<td>{{slash_decimal(facility_sgst($value->facility_id))}}</td>
		<td>{{$vat_amount}}</td>
		<td>{{ $amount_before_tax+$st_amount+$vat_amount }}</td>
	</tr>
	@endforeach
	@if($safai_charges>0)
	<tr>
		<td>{{$key+1}}</td>
		<td>Safai &amp; General</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{slash_decimal($safai_charges)}}</td>
		<td>{{slash_decimal($global_st)}}</td>
		<td>{{ percent_amount($global_st,$safai_charges) }}</td>
		<td>{{slash_decimal($global_vat)}}</td>
		<td>{{ percent_amount($global_vat,$safai_charges) }}</td>
		<td>{{slash_decimal($safai_charges+percent_amount($global_st,$safai_charges)+percent_amount($global_vat,$safai_charges))}}</td>
	</tr>
	@endif
	@if($generator_charges>0)
	<tr>
		<td>{{$key+2}}</td>
		<td>Generator</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td class="abt">{{slash_decimal($generator_charges)}}</td>
		<td>{{ slash_decimal($global_st) }}</td>
		<td class="cgst_amount">{{ percent_amount($global_st,$generator_charges) }}</td>
		<td>{{ slash_decimal($global_vat) }}</td>
		<td class="sgst_amount">{{ percent_amount($global_vat,$generator_charges) }}</td>
		<td>{{slash_decimal($generator_charges+percent_amount($global_st,$generator_charges)+percent_amount($global_vat,$generator_charges))}}</td>
	</tr>
	@endif
	@if($ac_charges>0)
	<tr>
		<td>{{$key+3}}</td>
		<td>AC</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td class="abt">{{slash_decimal($ac_charges)}}</td>
		<td>{{ slash_decimal($global_st) }}</td>
		<td class="cgst_amount">{{ percent_amount($global_st,$ac_charges) }}</td>
		<td>{{ slash_decimal($global_vat) }}</td>
		<td class="sgst_amount">{{ percent_amount($global_vat,$ac_charges) }}</td>
		<td>{{slash_decimal($ac_charges+percent_amount($global_st,$ac_charges)+percent_amount($global_vat,$ac_charges))}}</td>
	</tr>
	@endif
	@if($receipt[0]->misc != '')
      <tr>
        <td>{{ $key+4 }}</td>
        <td>{{$receipt[0]->misc}}</td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        <td class="abt">{{slash_decimal($receipt[0]->misc_amount)}}</td>
        <td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{slash_decimal($receipt[0]->misc_amount)}}</td>
      </tr>
    @endif
    @if($receipt[0]->others != '')
      <tr>
        <td>{{ $key+5 }}</td>
        <td>{{$receipt[0]->others}}</td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        <td class="abt">{{slash_decimal($receipt[0]->others_amount)}}</td>
        <td>{{ slash_decimal($global_st) }}</td>
		<td class="cgst_amount">{{ percent_amount($global_st,$receipt[0]->others_amount) }}</td>
		<td>{{ slash_decimal($global_vat) }}</td>
		<td class="sgst_amount">{{ percent_amount($global_vat,$receipt[0]->others_amount) }}</td>
		<td>{{ $receipt[0]->others_amount+percent_amount($global_st,$receipt[0]->others_amount)+percent_amount($global_vat,$receipt[0]->others_amount) }}</td>
      </tr>
    @endif
	<tr>
        <td style="border-right: none" colspan="13" class="right-align">Total Amount Before Tax:</td>
        <td class="left-align subTotal total-abt">{{$sub_total+$receipt[0]->misc_amount+$receipt[0]->others_amount}}</td>
	</tr>
	@if($receipt[0]->reverse_charges == '0')
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">CGST:</td>
        <td style="border-top: none" class="left-align subTotal total-cgst_amount">{{$cgst}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">SGST:</td>
        <td style="border-top: none" class="left-align subTotal total-sgst_amount">{{$sgst}}</td>
	</tr>
	<!--<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Tax:</td>
        <td style="border-top: none" class="left-align subTotal">{{$cgst+$sgst}}</td>
	</tr>-->
	@endif
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Reverse Charges:</td>
        <td style="border-top: none" class="left-align subTotal">{{$reverse_charges}}</td>
	</tr>
	@if($receipt[0]->with_security == '1')
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Security:</td>
        <td style="border-top: none" class="left-align subTotal">{{slash_decimal($security_charges)}}</td>
	</tr>
	@endif
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Amount:</td>
        <td style="border-top: none" class="left-align subTotal">{{round($total)}}</td>
	</tr>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>