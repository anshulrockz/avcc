@extends('layouts.website')
@section('content')
<?php
$booking_amount = $voucher->booking_facility_amount+$voucher->misc_amount+$voucher->others_amount;
$safai = $voucher->total_safai;
$generator = $voucher->total_generator;
$ac = $voucher->total_ac;
$tax = ($voucher->total_cgst+$voucher->total_sgst)*($voucher->booking_facility_amount+$voucher->misc_amount+$voucher->others_amount)/100;
$security = $voucher->total_security;
$deduction = $voucher->booking_facility_deduction+$voucher->misc_deduction+$voucher->others_deduction;
$final_amount = $booking_amount+$safai+$generator+$ac+$tax+$security-$deduction;
?>
<script>
	function printPage(){
		window.print();
	}
</script>
<div class="pageheader">
	<div class="media">
		<div class="pull-right">
			<button onclick="printPage();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
		</div>
        <div class="media-body">
    	<h4>Refund Voucher</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/refund-voucher') }}">Refund Voucher</a></li>
            <li>{{$voucher->id}}</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
      <h4 class="center onlyprint">ARUN VIHAR COMMUNITY CENTER </h4>
	  <h5 class="center onlyprint">SECTOR 37, NOIDA</h5>
	  <h5 class="center onlyprint">TEL: 2430288, 4273446 </h5>
	  <h4 class="center-underline onlyprint">Refund Voucher</h4>
	  <div class="col-md-9 table-responsive">
          <?php //echo "<pre>"; print_r($voucher); ?>
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="4">Voucher Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="facility-td"><b>Receipt No:</b></td>
                <td class="facility-td">{{$voucher->receipt_id}}</td>
                <td class="facility-td"><b>Voucher ID:</b></td>
                <td class="facility-td">{{$voucher->id}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Voucher Date:</b></td>
                <td class="facility-td">{{date_dfy($voucher->voucher_date)}}</td>
                <td class="facility-td"><b>Payment Mode:</b></td>
                <td class="facility-td">{{$voucher->payment_mode}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Cheque/DD No/Direct Txn No:</b></td>
                <td class="facility-td">{{$voucher->cheque_no}}</td>
                <td class="facility-td"><b>Dated:</b></td>
                <td class="facility-td">{{date_dfy($voucher->cheque_date)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Cheque Drawn:</b></td>
                <td class="facility-td">{{$voucher->cheque_drawn}}</td>
              </tr>
            </tbody>
          </table>
      </div>
	  <div class="col-md-5 table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="4">Particular Details</th>
              </tr>
            </thead>
            <tbody>
              @if($voucher->refund_type!='2')
              <tr>
                <td class="facility-td"><b>Booking Amount</b></td>
                <td class="facility-td">{{$booking_amount}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Safai</b></td>
                <td class="facility-td">(+) {{slash_decimal($voucher->total_safai)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Generator</b></td>
                <td class="facility-td">(+) {{slash_decimal($voucher->total_generator)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>AC</b></td>
                <td class="facility-td">(+) {{slash_decimal($voucher->total_ac)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Tax</b></td>
                <td class="facility-td">(+) {{$tax}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Security</b></td>
                <td class="facility-td">(+) {{slash_decimal($voucher->total_security)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Deduction</b></td>
                <td class="facility-td">(-) {{$deduction}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Toatl Amount</b></td>
                <td class="facility-td">{{$final_amount}}</td>
              </tr>
              @endif
              @if($voucher->refund_type=='2')
              <tr>
                <td class="facility-td"><b>Security</b></td>
                <td class="facility-td">{{ $voucher->security_refund }}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Deduction</b></td>
                <td class="facility-td">0.00</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Total Amount</b></td>
                <td class="facility-td">{{ $voucher->security_refund }}</td>
              </tr>
              @endif
            </tbody>
          </table>
      </div>
	  @if($voucher->refund_type!='2')
	  	<div class="col-md-12 table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="17">Facility Details</th>
              </tr>
            </thead>
            <tbody>
              @if(count($refund_facility)>0)
              <tr>
                <td style="min-width: 100px" class="left-align"><b>Facility</b></td>
                <td style="min-width: 100px" class="left-align"><b>Price</b></td>
                <td style="min-width: 100px" class="left-align"><b>Quantity</b></td>
                <td style="min-width: 150px" class="left-align"><b>No of Days</b></td>
                <td style="min-width: 150px" class="left-align"><b>Amount</b></td>
                <td style="min-width: 100px" class="left-align"><b>Deduction</b></td>
              </tr>
              @foreach ($refund_facility as $value)
              <tr>
                <td class="left-align">{{ $value->facility_name }}</td>
                <td class="left-align">{{ $value->price }}</td>
                <td class="left-align">{{ $value->quantity }}</td>
                <td class="left-align">{{ slash_decimal($value->noofdays) }}</td>
                <td class="left-align">{{ $value->price*$value->quantity*$value->noofdays }}</td>
                <td class="left-align">{{ $value->deduction }}</td>
              </tr>
              @endforeach
			  @endif
			  @if($voucher->misc_amount > 0)
			  <tr>
                <td class="left-align">{{ $voucher->misc }}</td>
                <td class="left-align">-</td>
                <td class="left-align">-</td>
                <td class="left-align">-</td>
                <td class="left-align">{{ $voucher->misc_amount }}</td>
                <td class="left-align">{{ $voucher->misc_deduction }}</td>
              </tr>
              @endif
              @if($voucher->others_amount > 0)
              <tr>
                <td class="left-align">{{ $voucher->others }}</td>
                <td class="left-align">-</td>
                <td class="left-align">-</td>
                <td class="left-align">-</td>
                <td class="left-align">{{ $voucher->others_amount }}</td>
                <td class="left-align">{{ $voucher->others_deduction }}</td>
              </tr>
			  @endif
            </tbody>
          </table>
      </div>
	  @endif
	  <div class="onlyprint" style="float: left; margin-top: 20px; font-weight: bold;">
      	(Signature of the Member)
      </div>
      <div class="onlyprint" style="float: right; margin-top: 20px; font-weight: bold;">
      	(Accountant/Cashier)
      </div>
      <div style="clear:both"></div>
      <div class="onlyprint" style="margin-top: 20px">
      	*Contribution to the Corpus Fund is being made by the Member with the specific direction that it shall form part of the Corpus Fund of AVCC and shall accordingly be used for creating and improvement of its infrastructural activities in the long term public interest.
      </div>
	</div>
</div>
</div>
@endsection