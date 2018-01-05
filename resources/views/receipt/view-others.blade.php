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
        <td class="facility-td"><?php echo $receipt[0]->receipt_no.'/'.date_dfy($receipt[0]->created_at); ?></td>
        <td class="facility-td"><b>Booking No/Date:</b></td>
        <td class="facility-td">@if(!empty($receipt[0]->booking_no)) {{ $receipt[0]->booking_no.'/'}} @endif
        {{ date_dfy($receipt[0]->updated_at)}}</td>
      </tr>
      <tr>
      	@if($receipt[0]->receipt_type == '5')
      	<td class="facility-td"><b>Party Name:</b></td>
      	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
      	@elseif($receipt[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank Name:</b></td>
      	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
      	@else
      	<td class="facility-td"><b>Membership No/Party Name:</b></td>
        <td class="facility-td"><?php echo $receipt[0]->membership_no.'/'.$receipt[0]->party_name; ?></td>
      	@endif
      	
      	@if($receipt[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank GSTIN:</b></td>
      	@else
      	<td class="facility-td"><b>Party GSTIN:</b></td>
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
        <td class="facility-td">{{ $receipt[0]->phone }}</td>
        <td class="facility-td"><b>Mobile:</b></td>
        <td class="facility-td">{{ $receipt[0]->mobile }}</td>
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
        <td class="facility-td">{{ $receipt[0]->comments }}</td>
      @endif
      </tr>
    </tbody>
  </table>
</div>
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
	@if($receipt[0]->security >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Security Deposit</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->security)}}</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{slash_decimal($receipt[0]->security)}}</td>
	</tr>
	<?php $total = $total+$receipt[0]->security; ?>
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
	@if($receipt[0]->misc >0)
	<tr>
		<td><?php echo $i = $i+1; ?></td>
		<td>Misc/Others</td>
		<td>00440035</td>
		<td>{{slash_decimal($receipt[0]->misc)}}</td>
		<td>@if($others_withtax > '0'){{slash_decimal($global_st)}} @else 0 @endif</td>
		<td>@if($others_withtax > '0'){{percent_amount($global_st,$receipt[0]->misc)}} @else 0 @endif</td>
		<td>@if($others_withtax > '0'){{slash_decimal($global_vat)}} @else 0 @endif</td>
		<td>@if($others_withtax > '0'){{ percent_amount($global_vat,$receipt[0]->misc) }} @else 0 @endif</td>
		<td>@if($others_withtax > '0'){{$receipt[0]->misc+percent_amount($global_st,$receipt[0]->misc)+percent_amount($global_vat,$receipt[0]->misc)}}@else {{slash_decimal($receipt[0]->misc)}} @endif</td>
	</tr>
	<?php $total = $total+$receipt[0]->misc; ?>
	@endif
    <tr>
        <td style="border-right: none" colspan="8" class="right-align">Total Amount Before Tax:</td>
        <td>{{$total}}</td>
	</tr>
	@if($others_withtax > '0')
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">CGST:</td>
        <td style="border-top: none;">{{percent_amount($global_st,$receipt[0]->misc)}}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">SGST:</td>
        <td style="border-top: none;">{{percent_amount($global_vat,$receipt[0]->misc)}}</td>
	</tr>
	@endif
	<!--<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Tax:</td>
        <td style="border-top: none;"></td>
	</tr>-->
	 
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Reverse Charges:</td>
        <td style="border-top: none;">
        	@if($receipt[0]->reverse_charges == '1')
        	{{round(percent_amount($global_st,$receipt[0]->misc)+percent_amount($global_vat,$receipt[0]->misc))}}
        	@else
        	0
        	@endif
        </td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Amount:</td>
        <td style="border-top: none;">
        	@if($others_withtax > '0')
        	{{round($total+percent_amount($global_st,$receipt[0]->misc)+percent_amount($global_vat,$receipt[0]->misc))}}
        	@else {{$total}} @endif
        </td>
	</tr>
</tbody>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>