<?php
if(empty($rebate)){
	$rebate = new StdClass;
	$rebate->safai = 0;
	$rebate->catering = 0;
	$rebate->tentage = 0;
	$rebate->electricity = 0;
}
$reverse_charges = 0;
$total_cgst = 0;
$total_sgst = 0;
$total_before_tax = 0;
if($receipt[0]->est_cof>0){
	$est_cof = $receipt[0]->est_cof-$rebate->safai-percent_amount($rebate->catering,$receipt[0]->est_cof);
	$safai_est_cof = $rebate->safai;
	$rebate_est_cof = percent_amount($rebate->catering,$receipt[0]->est_cof);
	
	$cgst_est_cof = percent_amount($global_st,$est_cof+$safai_est_cof+$rebate_est_cof);
	$sgst_est_cof = percent_amount($global_vat,$est_cof+$safai_est_cof+$rebate_est_cof);
	$total_est_cof = $est_cof+$safai_est_cof+$rebate_est_cof+$cgst_est_cof+$sgst_est_cof;

	$total_cgst = $total_cgst+$cgst_est_cof;
	$total_sgst = $total_sgst+$sgst_est_cof;
	$total_before_tax = $total_before_tax+$est_cof+$safai_est_cof+$rebate_est_cof;
}

if($receipt[0]->est_tentage>0){
	$est_tentage = $receipt[0]->est_tentage-$rebate->tentage-$rebate->electricity;
	$electricity_est_tentage = $rebate->electricity;
	$rebate_est_tentage = $rebate->tentage;
	
	$cgst_est_tentage = percent_amount($global_st,$est_tentage+$electricity_est_tentage+$rebate_est_tentage);
	$sgst_est_tentage = percent_amount($global_vat,$est_tentage+$electricity_est_tentage+$rebate_est_tentage);
	$total_est_tentage = $est_tentage+$electricity_est_tentage+$rebate_est_tentage+$cgst_est_tentage+$sgst_est_tentage;

	$total_cgst = $total_cgst+$cgst_est_tentage;
	$total_sgst = $total_sgst+$sgst_est_tentage;
	$total_before_tax = $total_before_tax+$est_tentage+$electricity_est_tentage+$rebate_est_tentage;
}

if($receipt[0]->est_catering>0){
	$est_catering = $receipt[0]->est_catering-percent_amount($rebate->catering,$receipt[0]->est_catering);
	$rebate_est_catering = percent_amount($rebate->catering,$receipt[0]->est_catering);
	
	$cgst_est_catering = percent_amount($global_st,$est_catering+$rebate_est_catering);
	$sgst_est_catering = percent_amount($global_vat,$est_catering+$rebate_est_catering);
	$total_est_catering = $est_catering+$rebate_est_catering+$cgst_est_catering+$sgst_est_catering;
	
	$total_cgst = $total_cgst+$cgst_est_catering;
	$total_sgst = $total_sgst+$sgst_est_catering;
	$total_before_tax = $total_before_tax+$est_catering+$rebate_est_catering;
}

if($receipt[0]->security_deposit>0){
	$security_deposit = $receipt[0]->security_deposit;
	$total_before_tax = $total_before_tax+$security_deposit;
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
		@if($receipt[0]->est_cof>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Estimated cost of food</td>
			<td>00440035</td>
			<td>{{slash_decimal($est_cof+$safai_est_cof+$rebate_est_cof)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_est_cof}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_est_cof}}</td>
			<td>{{$total_est_cof}}</td>
		</tr>
		@endif
		@if($receipt[0]->est_tentage>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Estimated cost of tentage</td>
			<td>00440035</td>
			<td>{{slash_decimal($est_tentage+$electricity_est_tentage+$rebate_est_tentage)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_est_tentage}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_est_tentage}}</td>
			<td>{{$total_est_tentage}}</td>
		</tr>
		@endif
		@if($receipt[0]->est_catering>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Estimated cost of catering</td>
			<td>00440035</td>
			<td>{{slash_decimal($est_catering+$rebate_est_catering)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{$cgst_est_catering}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{$sgst_est_catering}}</td>
			<td>{{$total_est_catering}}</td>
		</tr>
		@endif
		@if($receipt[0]->security_deposit>0)
		<tr>
			<td><?php echo $i = $i+1; ?></td>
			<td>Security Deposit</td>
			<td>00440035</td>
			<td>{{slash_decimal($receipt[0]->security_deposit)}}</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>{{slash_decimal($security_deposit)}}</td>
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