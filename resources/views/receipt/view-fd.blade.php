<?php
$sub_total = $receipt[0]->fd_principal_amt+$receipt[0]->fd_interest;
$tds = $sub_total*$receipt[0]->tds/100;
?>
<table class="table table-bordered">
<tbody>
	<tr>
		<th>S.NO</th>
		<th>Particular</th>
		<th>SAC Code</th>
		<th style="text-align: left">Amount</th>
	</tr>
	<?php $i = 0; ?>
	@if($receipt[0]->fd_principal_amt >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Principal Amount</td>
		<td>00440035</td>
		<td style="text-align: left">{{slash_decimal($receipt[0]->fd_principal_amt)}}</td>
	</tr>
	@endif
	@if($receipt[0]->fd_interest >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Interest</td>
		<td>00440035</td>
		<td style="text-align: left">{{slash_decimal($receipt[0]->fd_interest)}}</td>
	</tr>
	@endif
    <tr>
        <td style="border-right: none" colspan="3" class="right-align">Sub-Total:</td>
        <td style="text-align: left">{{slash_decimal($sub_total)}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="3" class="right-align">TDS ({{slash_decimal($receipt[0]->tds)}}%):</td>
        <td style="border-top: none; text-align: left">{{slash_decimal($tds)}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="3" class="right-align">Total Amount:</td>
        <td style="border-top: none; text-align: left">{{slash_decimal($sub_total-$tds)}}</td>
	</tr>
</tbody>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>