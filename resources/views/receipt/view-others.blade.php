<?php
$service_tax = 0;
$vat = 0;
$reverse_charges = 0;
if($receipt[0]->others_withtax >0){
    $service_tax = $receipt[0]->others_amount*$global_st/100;
    $vat = $receipt[0]->others_amount*$global_vat/100;
}
if($receipt[0]->reverse_charges == '1'){
	$reverse_charges = $service_tax+$vat;
}
?>
<table class="table table-bordered">
<tbody>
	<tr>
		<th rowspan="2">S.NO</th>
		<th rowspan="2">Particular</th>
		<th rowspan="2">SAC Code</th>
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
	<?php $i = 0; $total = 0; ?>
	@if($receipt[0]->security_deposit >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Security Deposit</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->security_deposit)}}</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{slash_decimal($receipt[0]->security_deposit)}}</td>
	</tr>
	<?php $total = $total+$receipt[0]->security_deposit; ?>
	@endif
	@if($receipt[0]->corpus_fund >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Corpus Fund</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->corpus_fund)}}</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{slash_decimal($receipt[0]->corpus_fund)}}</td>
	</tr>
	<?php $total = $total+$receipt[0]->corpus_fund; ?>
	@endif
	@if($receipt[0]->others_amount >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Misc/Others</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->others_amount)}}</td>
		<td>@if($receipt[0]->others_withtax == '1'){{slash_decimal($global_st)}} @else 0 @endif</td>
		<td>@if($receipt[0]->others_withtax == '1'){{percent_amount($global_st,$receipt[0]->others_amount)}} @else 0 @endif</td>
		<td>@if($receipt[0]->others_withtax == '1'){{slash_decimal($global_vat)}} @else 0 @endif</td>
		<td>@if($receipt[0]->others_withtax == '1'){{ percent_amount($global_vat,$receipt[0]->others_amount) }} @else 0 @endif</td>
		<td>@if($receipt[0]->others_withtax == '1'){{$receipt[0]->others_amount+percent_amount($global_st,$receipt[0]->others_amount)+percent_amount($global_vat,$receipt[0]->others_amount)}}@else {{slash_decimal($receipt[0]->others_amount)}} @endif</td>
	</tr>
	<?php $total = $total+$receipt[0]->others_amount; ?>
	@endif
    <tr>
        <td style="border-right: none" colspan="8" class="right-align">Total Amount Before Tax:</td>
        <td>{{$total}}</td>
	</tr>
	@if($receipt[0]->reverse_charges == '0')
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">CGST:</td>
        <td style="border-top: none;">{{$service_tax}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">SGST:</td>
        <td style="border-top: none;">{{$vat}}</td>
	</tr>
	<!--<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Tax:</td>
        <td style="border-top: none;">{{$service_tax+$vat}}</td>
	</tr>-->
	@endif
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Reverse Charges:</td>
        <td style="border-top: none;">{{$reverse_charges}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Amount:</td>
        <td style="border-top: none;">{{round($service_tax)+round($vat)+$total}}</td>
	</tr>
</tbody>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>