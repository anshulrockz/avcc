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
        <td class="facility-td">{{ $receipt_data[0]->receipt_no.'/'.date_dfy($receipt_data[0]->created_at) }}</td>
        <td class="facility-td"><b>Booking No/Date:</b></td>
        <td class="facility-td">@if(!empty($receipt[0]->booking_no)) {{ $receipt[0]->booking_no.'/'}} @endif
        {{ date_dfy($receipt[0]->updated_at)}}</td>
      </tr>
      <tr>
      	@if($receipt_data[0]->receipt_type == '5')
      	<td class="facility-td"><b>Party Name:</b></td>
      	<td class="facility-td">{{ $receipt_data[0]->party_name }}</td>
      	@elseif($receipt_data[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank Name:</b></td>
      	<td class="facility-td">{{ $receipt_data[0]->party_name }}</td>
      	@else
      	<td class="facility-td"><b>Membership No/Party Name:</b></td>
        <td class="facility-td">{{ $receipt_data[0]->membership_no.'/'.$receipt_data[0]->party_name }}</td>
      	@endif
      	
      	@if($receipt_data[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank GSTIN:</b></td>
      	@else
      	<td class="facility-td"><b>Party GSTIN:</b></td>
      	@endif
        <td class="facility-td">{{$receipt_data[0]->party_gstin}}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Reverse Charges:</b></td>
        <td class="facility-td">@if($receipt_data[0]->reverse_charges == '1') Yes @else No @endif</td>
        <td class="facility-td"><b>Function Date:</b></td>
        <td class="facility-td">{{ date_dfy($receipt_data[0]->function_date) }}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Phone:</b></td>
        <td class="facility-td">{{ $receipt_data[0]->phone }}</td>
        <td class="facility-td"><b>Mobile:</b></td>
        <td class="facility-td">{{ $receipt_data[0]->mobile }}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Address:</b></td>
        <td class="facility-td">{{ $receipt_data[0]->address }}</td>
        <td class="facility-td"><b>Payment Mode:</b></td>
        @if($receipt_data[0]->payment_mode == 'Cheque' || $receipt_data[0]->payment_mode == 'DD')
        <td class="facility-td">{{ $receipt_data[0]->payment_mode.'/'.$receipt_data[0]->cheque_no.'/'.date_dfy($receipt_data[0]->cheque_date).'/'.$receipt_data[0]->cheque_drawn }}</td>
        @else
        <td class="facility-td">{{ $receipt_data[0]->payment_mode }}</td>
        @endif
      </tr>
      
      <tr>
      @if($receipt_data[0]->receipt_type == '3' || $receipt_data[0]->receipt_type == '8')
        <td class="facility-td"><b>Contractor Name:</b></td>
        <td class="facility-td">{{ $contractor->getContractorName($receipt_data[0]->contractor_id) }}</td>
      @endif
      @if(!empty($receipt[0]->comments))
      	<td class="facility-td"><b>Comments:</b></td>
        <td class="facility-td">{{ $receipt[0]->comments }}</td>
      @endif
      </tr>
    </tbody>
  </table>
</div>
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
		<?php 
			$i = $total = 0;
			$amount_permises = $receipt_data[0]->rent_premises;
			$amount_permises_tax_st = ($amount_permises*$global_st)/100;
			$amount_permises_tax_vat = ($amount_permises*$global_vat)/100;
			$total_amount_permises = $amount_permises+$amount_permises_tax_st+$amount_permises_tax_vat;
			$total=$amount_permises;
		?>
		@if($receipt_data[0]->rent_premises >0)
		<tr>
			<td><?php  echo $i = $i+1;?></td>
			<td>Rent Permises</td>
			<td>00440035</td>
			<td>{{slash_decimal($amount_permises)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{round($amount_permises_tax_st)}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{round($amount_permises_tax_vat)}}</td>
			<td>{{round($total_amount_permises)}}</td>
		</tr>
		@endif
		<?php
			$amount_store = $receipt_data[0]->rent_store;
			$amount_store_tax_st = ($amount_store*$global_st)/100;
			$amount_store_tax_vat = ($amount_store*$global_vat)/100;
			$total_amount_store = $amount_store+$amount_store_tax_st+$amount_store_tax_vat;
			$total=$total+$amount_store;
		?>
		@if($receipt_data[0]->rent_store >0)
		<tr>
			<td><?php  echo $i = $i+1;?></td>
			<td>Rent Store</td>
			<td>00440035</td>
			<td>{{slash_decimal($amount_store)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{round($amount_store_tax_st)}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{round($amount_store_tax_vat)}}</td>
			<td>{{round($total_amount_store)}}</td>
		</tr>
		@endif
		<?php
			$amount_atm = $receipt_data[0]->rent_atm;
			$amount_atm_tax_st = ($amount_atm*$global_st)/100;
			$amount_atm_tax_vat = ($amount_atm*$global_vat)/100;
			$total_amount_atm = $amount_atm+$amount_atm_tax_st+$amount_atm_tax_vat;
			$total=$total+$amount_atm;
		?>
		@if($receipt_data[0]->rent_atm >0)
		<tr>
			<td><?php  echo $i = $i+1;?></td>
			<td>Rent ATM</td>
			<td>00440035</td>
			<td>{{slash_decimal($amount_atm)}}</td>
			<td>{{slash_decimal($global_st)}}</td>
			<td>{{round($amount_atm_tax_st)}}</td>
			<td>{{slash_decimal($global_vat)}}</td>
			<td>{{round($amount_atm_tax_vat)}}</td>
			<td>{{round($total_amount_atm)}}</td>
		</tr>
		@endif
	    <tr>
	        <td style="border-right: none" colspan="8" class="right-align">Total Amount Before Tax:</td>
	        <td>{{round($amount_atm+$amount_store+$amount_permises)}}</td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">TDS ({{$receipt_data[0]->tds}}%):</td>
	        <td style="border-top: none;">{{ round(percent_amount($total,$receipt_data[0]->tds)) }}</td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">CGST:</td>
	        <td style="border-top: none;">{{round($amount_atm_tax_st+$amount_store_tax_st+$amount_permises_tax_st)}}</td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">SGST:</td>
	        <td style="border-top: none;">{{round($amount_atm_tax_vat+$amount_store_tax_vat+$amount_permises_tax_vat)}}</td>
		</tr>
		<!--<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Tax:</td>
	        <td style="border-top: none;"></td>
		</tr>-->
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Reverse Charges:</td>
	        <td style="border-top: none;">
	        	@if($receipt_data[0]->reverse_charges == '1')
	        		{{ round(percent_amount($total,$global_st+$global_vat)) }}
	        	@else
	        		0
	        	@endif
	        </td>
		</tr>
		<tr>
	        <td style="border-top: none;border-right: none" colspan="8" class="right-align">Total Amount:</td>
	        <td style="border-top: none;">{{round($total_amount_atm+$total_amount_store+$total_amount_permises-percent_amount($total,$receipt_data[0]->tds))}}</td>
		</tr>
	</tbody>
	</table>
</div>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>