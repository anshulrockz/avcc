<div class="table-responsive">
  <table class="table mb30">
    <thead>
      <tr>
        <th class="facility-th" colspan="4">Booking Entry</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="facility-td"><b>Receipt No/Date:</b></td>
        <td class="facility-td">{{ $receipt[0]->receipt_no.'/'.date_dfy($receipt[0]->created_at) }}</td>
        <td class="facility-td"><b>Booking No/Date:</b></td>
        <td class="facility-td">@if(!empty($receipt[0]->booking_no)){{$receipt[0]->booking_no.'/'}} @endif {{ date_dfy($receipt[0]->updated_at) }} </td>
      </tr>
      <tr>
      	@if($receipt[0]->receipt_type == '5')
      	<td class="facility-td"><b>Bank Name:</b></td>
      	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
      	@elseif($receipt[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank Name:</b></td>
      	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
      	@else
      	<td class="facility-td"><b>Bank Name:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
      	@endif
      	
      	@if($receipt[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank GSTIN:</b></td>
      	@else
      	<td class="facility-td"><b>Bank GSTIN:</b></td>
      	@endif
        <td class="facility-td">{{$receipt[0]->party_gstin}}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Reverse Charges:</b></td>
        <td class="facility-td">@if($receipt[0]->reverse_charges == '1') Yes @else No @endif</td>
        <td class="facility-td"><b>Function Date:</b></td>
        <td class="facility-td"><?php echo date_dfy($receipt[0]->function_date); ?></td>
      </tr>
      <tr>
        <td class="facility-td"><b>Phone:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->phone; ?></td>
        <td class="facility-td"><b>Mobile:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->mobile; ?></td>
      </tr>
      <tr>
        <td class="facility-td"><b>Address:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->address; ?></td>
        <td class="facility-td"><b>Payment Mode:</b></td>
        @if($receipt[0]->payment_mode == 'Cheque' || $receipt[0]->payment_mode == 'DD')
        <td class="facility-td"><?php echo $receipt[0]->payment_mode.'/'.$receipt[0]->cheque_no.'/'.date_dfy($receipt[0]->cheque_date).'/'.$receipt[0]->cheque_drawn; ?></td>
        @else
        <td class="facility-td"><?php echo $receipt[0]->payment_mode; ?></td>
        @endif
      </tr>
      <tr>
      @if($receipt[0]->receipt_type == '3' || $receipt[0]->receipt_type == '8')
        <td class="facility-td"><b>Contractor Name:</b></td>
        <td class="facility-td"><?php echo $contractor->getContractorName($receipt[0]->contractor_id); ?></td>
      @endif
     	@if(!empty($receipt[0]->comments))
      	<td class="facility-td"><b>Comments:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->comments; ?></td>
      @endif
      </tr>
    </tbody>
  </table>
</div>
<table class="table table-bordered">
<tbody>
	<tr>
		<th>S.NO</th>
		<th>Particular</th>
		<th>SAC Code</th>
		<th style="text-align: left">Amount</th>
	</tr>
	<?php $i = 0; ?>
	@if($receipt[0]->principal_amount >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Principal Amount</td>
		<td>00440035</td>
		<td style="text-align: left">{{slash_decimal($receipt[0]->principal_amount )}}</td>
	</tr>
	@endif
	@if($receipt[0]->interest >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Interest</td>
		<td>00440035</td>
		<td style="text-align: left">{{slash_decimal($receipt[0]->interest)}}</td>
	</tr>
	@endif
    <tr>
        <td style="border-right: none" colspan="3" class="right-align">Sub-Total:</td>
        <td style="text-align: left">{{slash_decimal($receipt[0]->principal_amount+$receipt[0]->interest)}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="3" class="right-align">TDS ({{slash_decimal($receipt[0]->tds)}}%):</td>
        <td style="border-top: none; text-align: left">{{(round($receipt[0]->principal_amount+$receipt[0]->interest)*$receipt[0]->tds)/100}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="3" class="right-align">Reverse Charges:</td>
        <td style="border-top: none; text-align: left">
        	@if($receipt[0]->reverse_charges == '1')
        	{{(round($receipt[0]->principal_amount+$receipt[0]->interest)*$receipt[0]->tds)/100}}
        	@else
        	0
        	@endif
        </td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="3" class="right-align">Total Amount:</td>
        <td style="border-top: none; text-align: left">{{slash_decimal($receipt[0]->principal_amount+$receipt[0]->interest)-slash_decimal($receipt[0]->tds)}}</td>
	</tr>
</tbody>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>