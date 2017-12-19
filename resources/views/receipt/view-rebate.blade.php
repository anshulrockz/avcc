<?php
$reverse_charges = 0;
$total_cgst = 0;
$total_sgst = 0;
$total_before_tax = 0;
if($receipt_rebate->safai>0){
	$safai = $receipt_rebate->safai;
	$cgst_safai = percent_amount($global_st,$safai);
	$sgst_safai = percent_amount($global_vat,$safai);
	$total_safai = $safai+$cgst_safai+$sgst_safai;
	
	$total_cgst = $total_cgst+$cgst_safai;
	$total_sgst = $total_sgst+$sgst_safai;
	$total_before_tax = $total_before_tax+$safai;
}
if($receipt_rebate->tentage>0){
	$tentage = $receipt_rebate->tentage;
	$cgst_tentage = percent_amount($global_st,$tentage);
	$sgst_tentage = percent_amount($global_vat,$tentage);
	$total_tentage = $tentage+$cgst_tentage+$sgst_tentage;
	
	$total_cgst = $total_cgst+$cgst_tentage;
	$total_sgst = $total_sgst+$sgst_tentage;
	$total_before_tax = $total_before_tax+$tentage;
}
if($receipt_rebate->catering>0){
	$catering = $receipt_rebate->catering;
	$cgst_catering = percent_amount($global_st,$catering);
	$sgst_catering = percent_amount($global_vat,$catering);
	$total_catering = $catering+$cgst_catering+$sgst_catering;
	
	$total_cgst = $total_cgst+$cgst_catering;
	$total_sgst = $total_sgst+$sgst_catering;
	$total_before_tax = $total_before_tax+$catering;
}
if($receipt_rebate->food>0){
	$food = $receipt_rebate->food;
	$cgst_food = percent_amount($global_st,$food);
	$sgst_food = percent_amount($global_vat,$food);
	$total_food = $food+$cgst_food+$sgst_food;
	
	$total_cgst = $total_cgst+$cgst_food;
	$total_sgst = $total_sgst+$sgst_food;
	$total_before_tax = $total_before_tax+$food;
}
if($receipt_rebate->electricity>0){
	$electricity = $receipt_rebate->electricity;
	$cgst_electricity = percent_amount($global_st,$electricity);
	$sgst_electricity = percent_amount($global_vat,$electricity);
	$total_electricity = $electricity+$cgst_electricity+$sgst_electricity;
	
	$total_cgst = $total_cgst+$cgst_electricity;
	$total_sgst = $total_sgst+$sgst_electricity;
	$total_before_tax = $total_before_tax+$electricity;
}

if($receipt[0]->reverse_charges == '1'){
	$reverse_charges = $total_cgst+$total_sgst;
}

?>
<div class="table-responsive">
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
		<?php $i = 0;?>
		@if($receipt_rebate->safai>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Rebate on safai</td>
			<td>00440035</td>
			<td>{{slash_decimal($safai)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_safai}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_safai}}</td>
			<td>{{$total_safai}}</td>
		</tr>
		@endif
		@if($receipt_rebate->tentage>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Rebate on tentage</td>
			<td>00440035</td>
			<td>{{slash_decimal($tentage)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_tentage}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_tentage}}</td>
			<td>{{$total_tentage}}</td>
		</tr>
		@endif
		@if($receipt_rebate->catering>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Rebate on catering</td>
			<td>00440035</td>
			<td>{{slash_decimal($catering)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_catering}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_catering}}</td>
			<td>{{$total_catering}}</td>
		</tr>
		@endif
		@if($receipt_rebate->food>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Rebate on food</td>
			<td>00440035</td>
			<td>{{slash_decimal($food)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_food}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_food}}</td>
			<td>{{$total_food}}</td>
		</tr>
		@endif
		@if($receipt_rebate->electricity>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Rebate on electricity</td>
			<td>00440035</td>
			<td>{{slash_decimal($electricity)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_electricity}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_electricity}}</td>
			<td>{{$total_electricity}}</td>
		</tr>
		@endif
		<tr>
	        <td style="border-right: none" colspan="8" class="right-align">Total Amount Before Tax:</td>
	        <td>{{$total_before_tax}}</td>
		</tr>
			<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">CGST:</td>
	        <td style="border-top: none;">{{$total_cgst}}</td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">SGST:</td>
	        <td style="border-top: none;">{{$total_sgst}}</td>
		</tr>
		<!--<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Tax:</td>
	        <td style="border-top: none;">{{$total_cgst+$total_sgst}}</td>
		</tr>-->
			<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Reverse Charges:</td>
	        <td style="border-top: none;">{{$reverse_charges}}</td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Amount:</td>
	        <td style="border-top: none;">{{$total_before_tax+$total_cgst+$total_sgst}}</td>
		</tr>
	</tbody>
  </table>
</div>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>