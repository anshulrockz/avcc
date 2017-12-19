@extends('layouts.website')
@section('content')
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
                <td class="facility-td"><b>Receipt Voucher:</b></td>
                <td class="facility-td">{{$voucher->receipt_id}}</td>
                <td class="facility-td"><b>Voucher ID:</b></td>
                <td class="facility-td">{{$voucher->id}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Voucher Date:</b></td>
                <td class="facility-td">{{date_dfy($voucher->voucher_date)}}</td>
                <td class="facility-td"><b>Membership No:</b></td>
                <td class="facility-td">{{$voucher->membership_no}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Booking No:</b></td>
                <td class="facility-td">{{$voucher->booking_no}}</td>
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
            @if($voucher->refund_type!='2')
            <tbody>
              <tr>
                <td class="facility-td"><b>Amount (Without Tax)</b></td>
                <td class="facility-td">{{slash_decimal($voucher->amount)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Deduction</b></td>
                <td class="facility-td">(-) {{slash_decimal($voucher->deduction)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>After Deduction</b></td>
                <td class="facility-td">{{slash_decimal($voucher->amount)-slash_decimal($voucher->deduction)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Security</b></td>
                <td class="facility-td">(+) {{slash_decimal($voucher->security)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Refunded Amount:</b></td>
                <td class="facility-td">{{slash_decimal($voucher->security)+slash_decimal($voucher->amount)-slash_decimal($voucher->deduction)}}</td>
              </tr>
            </tbody>
            @endif
            @if($voucher->refund_type=='2')
            <tbody>
              <tr>
                <td class="facility-td"><b>Security</b></td>
                <td class="facility-td">{{slash_decimal($voucher->security)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Deduction</b></td>
                <td class="facility-td">(-) 0</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Refunded Amount:</b></td>
                <td class="facility-td">{{slash_decimal($voucher->security)-slash_decimal($voucher->deduction)}}</td>
              </tr>
            </tbody>
            @endif
          </table>
      </div>
      @if(count($refund_facility)>0)
	  <div class="col-md-12 table-responsive" style="overflow-x: scroll">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="17">Facility Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="min-width: 100px" class="left-align"><b>Facility</b></td>
                <td style="min-width: 100px" class="left-align"><b>Quantity</b></td>
                <td style="min-width: 100px" class="left-align"><b>No of Days</b></td>
                <td style="min-width: 150px" class="left-align"><b>From Date</b></td>
                <td style="min-width: 150px" class="left-align"><b>To Date</b></td>
                <td style="min-width: 100px" class="left-align"><b>Booking Rate</b></td>
                <td style="min-width: 100px" class="left-align"><b>Safai &amp; General</b></td>
                <td style="min-width: 100px" class="left-align"><b>Generator</b></td>
                <td style="min-width: 100px" class="left-align"><b>AC</b></td>
                <td style="min-width: 100px" class="left-align"><b>Security</b></td>
              </tr>
              <?php if(count($refund_facility)>0){?>
              @foreach ($refund_facility as $value)
              <tr>
                <td class="left-align">{{ $value->facility_name }}</td>
                <td class="left-align">{{ $value->quantity }}</td>
                <td class="left-align">{{ slash_decimal($value->noofdays) }}</td>
                <td class="left-align">{{ date_dfy($value->from_date) }}</td>
                <td class="left-align">{{ date_dfy($value->to_date) }}</td>
                <td class="left-align">{{ $value->booking_rate }}</td>
                <td class="left-align">{{ $value->safai_general }}</td>
                <td class="left-align">{{ $value->generator_charges }}</td>
                <td class="left-align">{{ $value->ac_charges }}</td>
                <td class="left-align">{{ $value->security_charges }}</td>
              </tr>
              @endforeach
			  <?php }?>
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