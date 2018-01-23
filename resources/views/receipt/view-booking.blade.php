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
        <td class="facility-td">@if(!empty($receipt[0]->booking_no)) {{ $receipt[0]->booking_no.'/'}} @endif
        {{ date_dfy($receipt[0]->created_at)}}</td>
      </tr>
      <tr>
      	@if($receipt[0]->receipt_type == '5')
      	<td class="facility-td"><b>Party Name:</b></td>
      	<td class="facility-td">{{ $receipt[0]->party_name }}</td>
      	@elseif($receipt[0]->receipt_type == '6')
      	<td class="facility-td"><b>Bank Name:</b></td>
      	<td class="facility-td">{{ $receipt[0]->party_name }}</td>
      	@else
      	<td class="facility-td"><b>Membership No/Party Name:</b></td>
        <td class="facility-td">{{ $receipt[0]->membership_no.'/'.$receipt[0]->party_name }}</td>
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
        <td class="facility-td">{{ date_dfy($receipt[0]->function_date) }}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Phone:</b></td>
        <td class="facility-td">{{ $receipt[0]->phone }}</td>
        <td class="facility-td"><b>Mobile:</b></td>
        <td class="facility-td">{{ $receipt[0]->mobile }}</td>
      </tr>
      <tr>
        <td class="facility-td"><b>Address:</b></td>
        <td class="facility-td">{{ $receipt[0]->address }}</td>
        <td class="facility-td"><b>Payment Mode:</b></td>
        @if($receipt[0]->payment_mode == 'Cheque' || $receipt[0]->payment_mode == 'DD')
        <td class="facility-td">{{ $receipt[0]->payment_mode.'/'.$receipt[0]->cheque_no.'/'.date_dfy($receipt[0]->cheque_date).'/'.$receipt[0]->cheque_drawn }}</td>
        @else
        <td class="facility-td">{{ $receipt[0]->payment_mode }}</td>
        @endif
      </tr>
      
      <tr>
      @if(!empty($receipt[0]->comments))
      	<td class="facility-td"><b>Comments:</b></td>
        <td class="facility-td">{{ $receipt[0]->comments }}</td>
      @endif
      </tr>
    </tbody>
  </table>
</div>
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
	@php 
		$i = $total = $security = 0;
		$key = $safai_charges = $generator_charges = $ac_charges = 0;
	@endphp
	
	@foreach( $facility as $key=>$value )
	@php
		$sgst = $value->servicetax_percentage;
		$cgst = $value->vat_percentage;
		$total += $value->quantity*$value->booking_rate*$value->noofdays + $value->safai_total + $value->generator_total + $value->ac_total;
		$security += $value->security_total;
		$safai_charges = $safai_charges + $value->safai_total;
		$generator_charges = $generator_charges + $value->generator_total;
		$ac_charges = $ac_charges + $value->ac_total;
	@endphp
	<tr>
		<td>{{ ++$key }}</td>
		<td>{{ $value->name }}</td>
		<td>{{ $value->sac_code }}</td>
		<td>{{ date_dmy($value->from_date) }}</td>
		<td>{{ date_dmy($value->to_date) }}</td>
		<td>{{ $value->quantity }}</td>
		<td>{{ $value->noofdays }}</td>
		<td>{{ slash_decimal($value->booking_rate) }}</td>
		<td>{{ slash_decimal($value->quantity*$value->booking_rate*$value->noofdays) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($value->quantity*$value->booking_rate*$value->noofdays,$cgst)) }}</td>
		<td>{{ slash_decimal($sgst)}}</td>
		<td>{{ slash_decimal(percent_amount($value->quantity*$value->booking_rate*$value->noofdays,$sgst)) }}</td>
		<td>{{ slash_decimal($value->quantity*$value->booking_rate*$value->noofdays)+percent_amount(($value->quantity*$value->booking_rate*$value->noofdays),$cgst+$sgst) }}</td>
	</tr>
	@endforeach
	@if($safai_charges>0)
	<tr>
		<td>{{++$key}}</td>
		<td>Safai &amp; General</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{ slash_decimal($safai_charges) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($safai_charges,$cgst)) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($safai_charges,$sgst)) }}</td>
		<td>{{ slash_decimal($safai_charges + percent_amount($safai_charges,$cgst)) }}</td>
	</tr>
	@endif
	@if($generator_charges>0)
	<tr>
		<td>{{++$key}}</td>
		<td>Generator</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{ slash_decimal($generator_charges) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($generator_charges,$cgst)) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($generator_charges,$sgst)) }}</td>
		<td>{{ slash_decimal($generator_charges + percent_amount($generator_charges,$cgst+$sgst)) }}</td>
	</tr>
	@endif
	@if($ac_charges>0)
	<tr>
		<td>{{++$key}}</td>
		<td>AC</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{ slash_decimal($ac_charges) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($ac_charges,$cgst)) }}</td>
		<td>{{ slash_decimal($cgst) }}</td>
		<td>{{ slash_decimal(percent_amount($ac_charges,$sgst)) }}</td>
		<td>{{ slash_decimal($ac_charges + percent_amount($ac_charges,$cgst+$sgst)) }}</td>
	</tr>
	@endif
	@if($receipt[0]->others_amount>0)
	@php
	$total += $receipt[0]->others_amount;
	@endphp
      <tr>
        <td>{{++$key}}</td>
        <td>{{$receipt[0]->others}}</td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        <td class="abt">{{$receipt[0]->others_amount}}</td>
        <td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{$receipt[0]->others_amount}}</td>
      </tr>
	@endif
	@if($receipt[0]->misc_amount>0)
    @php
	$total += $receipt[0]->misc_amount;
	@endphp
      <tr>
        <td>{{++$key}}</td>
        <td>{{$receipt[0]->misc}}</td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        <td class="abt">{{$receipt[0]->misc_amount}}</td>
        <td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{$receipt[0]->misc_amount}}</td>
      </tr>
    @endif
	<tr>
        <td style="border-right: none" colspan="13" class="right-align">Total Amount Before Tax:</td>
        <td class="left-align subTotal total-abt">{{ $total }}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">CGST:</td>
        <td style="border-top: none" class="left-align subTotal total-cgst_amount">{{round(percent_amount($total,$cgst)) }}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">SGST:</td>
        <td style="border-top: none" class="left-align subTotal total-sgst_amount">{{round(percent_amount($total,$sgst))  }}</td>
	</tr>
	<!--<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Tax:</td>
        <td style="border-top: none" class="left-align subTotal"></td>
	</tr>-->
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Reverse Charges:</td>
        <td style="border-top: none" class="left-align subTotal">
        	@if($receipt[0]->reverse_charges == '1')
	        	{{round(percent_amount($total,$cgst+$sgst))}}
	        @else
	        	0 
	        @endif
        </td>
	</tr>
	@if($receipt[0]->with_security == '1')
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Security:</td>
        <td style="border-top: none" class="left-align subTotal">
            	{{round($security)}}
	        @else
	        	{{$security=0}} 
	    </td>
	</tr>
	@endif
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Amount:</td>
        <td style="border-top: none" class="left-align subTotal">{{round($security + $total + percent_amount($total,$cgst+$sgst))}}</td>
	</tr>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>