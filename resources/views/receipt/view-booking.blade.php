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
        {{ date_dfy($receipt[0]->created_at)}}</td>
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
	@foreach( $facility as $key=>$value )
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
		<td>{{ slash_decimal($global_st) }}</td>
		<td>{{ slash_decimal($value->quantity*$value->booking_rate*$value->noofdays*$global_st)/100 }}</td>
		<td>{{ slash_decimal($global_vat)}}</td>
		<td>{{ slash_decimal($value->quantity*$value->booking_rate*$value->noofdays*$global_st)/100 }}</td>
		<td>{{ slash_decimal($value->quantity*$value->booking_rate*$value->noofdays)+slash_decimal($value->quantity*$value->booking_rate*$value->noofdays*($global_st+$global_vat))/100 }}</td>
	</tr>
	@endforeach
	<tr>
		<td>{{++$key}}</td>
		<td>Safai &amp; General</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>16</td>
		<td>17</td>
		<td>18</td>
		<td>19</td>
		<td>20</td>
		<td>21</td>
	</tr>
	<tr>
		<td>{{++$key}}</td>
		<td>Generator</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>{{ $value->generator_charges }}</td>
		<td class="abt">23</td>
		<td>{{ slash_decimal($global_st) }}</td>
		<td class="cgst_amount">11</td>
		<td>{{ slash_decimal($global_vat) }}</td>
		<td class="sgst_amount">11</td>
		<td>1</td>
	</tr>
	<tr>
		<td>{{++$key}}</td>
		<td>AC</td>
		<td>00440035</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td class="abt">{{ $value->ac_charges }}</td>
		<td>{{slash_decimal($global_st) }}</td>
		<td class="cgst_amount"> </td>
		<td>{{ slash_decimal($global_vat) }}</td>
		<td class="sgst_amount"></td>
		<td></td>
	</tr>
      <tr>
        <td></td>
        <td></td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        <td class="abt"></td>
        <td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>00440035</td>
        <td>-</td>
        <td>-</td>
		<td>-</td>
        <td>-</td>
        <td>-</td>
        
      </tr>
	<tr>
        <td style="border-right: none" colspan="13" class="right-align">Total Amount Before Tax:</td>
        <td class="left-align subTotal total-abt"></td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">CGST:</td>
        <td style="border-top: none" class="left-align subTotal total-cgst_amount">{{ slash_decimal($global_st) }}</td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">SGST:</td>
        <td style="border-top: none" class="left-align subTotal total-sgst_amount">{{ slash_decimal($global_vat) }}</td>
	</tr>
	<!--<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Tax:</td>
        <td style="border-top: none" class="left-align subTotal"></td>
	</tr>-->
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Reverse Charges:</td>
        <td style="border-top: none" class="left-align subTotal"></td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Security:</td>
        <td style="border-top: none" class="left-align subTotal"></td>
	</tr>
	<tr>
        <td style="border-top: none;border-right: none" colspan="13" class="right-align">Total Amount:</td>
        <td style="border-top: none" class="left-align subTotal"></td>
	</tr>
</table>
<p style="color: red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</p>