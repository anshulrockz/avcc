<?php
$cgst_percentage = 0;
$sgst_percentage = 0;
$reverse_charges = 0;
$rent_premises = 0;
$rent_store = 0;
$rent_atm = 0;
$tds = 0;

if($receipt[0]->tds>0){
	$tds = $receipt[0]->tds;
}
if($receipt[0]->rent_premises>0){
	$rent_premises = $receipt[0]->rent_premises;
}
if($receipt[0]->rent_store>0){
	$rent_store = $receipt[0]->rent_store;
}
if($receipt[0]->rent_atm>0){
	$rent_atm = $receipt[0]->rent_atm;
}

if($receipt[0]->with_tax >0){
	$cgst_percentage = $global_st;
	$sgst_percentage = $global_vat;
}

$total_cgst = round($rent_premises*$cgst_percentage/100+$rent_store*$cgst_percentage/100+$rent_atm*$cgst_percentage/100);
$total_sgst = round($rent_premises*$sgst_percentage/100+$rent_store*$sgst_percentage/100+$rent_atm*$sgst_percentage/100);
$total_rent_premises = $rent_premises+round($receipt[0]->rent_premises*$cgst_percentage/100)+round($receipt[0]->rent_premises*$cgst_percentage/100);
$total_rent_store = round($rent_store+$rent_store*$cgst_percentage/100+$rent_store*$sgst_percentage/100);
$total_rent_atm = round($rent_atm+$rent_atm*$cgst_percentage/100+$rent_atm*$sgst_percentage/100);
$total_before_tax = round($rent_premises+$rent_store+$rent_atm);
$tds_amount = $total_before_tax*$tds/100;

$total = $total_before_tax-$tds_amount+$total_cgst+$total_sgst;

if($receipt[0]->reverse_charges == '1'){
	$reverse_charges = $total_cgst+$total_sgst;
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
	<?php $i = 0; ?>
	@if($receipt[0]->rent_premises >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Rent Permises</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->rent_premises)}}</td>
		<td>{{slash_decimal($cgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_premises*$cgst_percentage/100)}}</td>
		<td>{{slash_decimal($sgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_premises*$sgst_percentage/100)}}</td>
		<td>{{$total_rent_premises}}</td>
	</tr>
	@endif
	@if($receipt[0]->rent_store >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Rent Store</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->rent_store)}}</td>
		<td>{{slash_decimal($cgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_store*$cgst_percentage/100)}}</td>
		<td>{{slash_decimal($sgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_store*$sgst_percentage/100)}}</td>
		<td>{{$total_rent_store}}</td>
	</tr>
	@endif
	@if($receipt[0]->rent_atm >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Rent ATM</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->rent_atm)}}</td>
		<td>{{slash_decimal($cgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_atm*$cgst_percentage/100)}}</td>
		<td>{{slash_decimal($sgst_percentage)}}</td>
		<td>{{round($receipt[0]->rent_atm*$sgst_percentage/100)}}</td>
		<td>{{$total_rent_atm}}</td>
	</tr>
	@endif
    <tr>
        <td style="border-right: none" colspan="8" class="right-align">Total Amount Before Tax:</td>
        <td>{{$total_before_tax}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">TDS ({{slash_decimal($tds)}}%):</td>
        <td style="border-top: none;">{{$tds_amount}}</td>
	</tr>
	@if($receipt[0]->reverse_charges == '0')
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
	@endif
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Reverse Charges:</td>
        <td style="border-top: none;">{{$reverse_charges}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Amount:</td>
        <td style="border-top: none;">{{$total}}</td>
	</tr>
</tbody>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>