@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
        <div class="media-body">
    	<h4>Refund Voucher</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/refund-voucher') }}">Refund Voucher</a></li>
            <li>{{$voucher[0]->id}}</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	  <div class="col-md-6 table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="4">Voucher Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="facility-td"><b>Voucher ID:</b></td>
                <td class="facility-td">{{$voucher[0]->id}}</td>
                <td class="facility-td"><b>Voucher Date:</b></td>
                <td class="facility-td">{{date_dfy($voucher[0]->voucher_date)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Membership No:</b></td>
                <td class="facility-td">{{$voucher[0]->membership_no}}</td>
                <td class="facility-td"><b>Booking No:</b></td>
                <td class="facility-td">{{$voucher[0]->booking_no}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Total Amount:</b></td>
                <td class="facility-td">{{$voucher[0]->total_amount}}</td>
                <td class="facility-td"><b>Deduction:</b></td>
                <td class="facility-td">{{$voucher[0]->deduction}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Refunded Amount:</b></td>
                <td class="facility-td">{{$voucher[0]->refunded_amount}}</td>
                <td class="facility-td"><b>Payment Mode:</b></td>
                <td class="facility-td">{{$voucher[0]->payment_mode}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Cheque/DD No/Direct Txn No:</b></td>
                <td class="facility-td">{{$voucher[0]->cheque_no}}</td>
                <td class="facility-td"><b>Dated:</b></td>
                <td class="facility-td">{{date_dfy($voucher[0]->cheque_date)}}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Cheque Drawn:</b></td>
                <td class="facility-td">{{$voucher[0]->cheque_drawn}}</td>
              </tr>
            </tbody>
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
                <td style="min-width: 100px" class="left-align"><b>Safai (Rebate)</b></td>
                <td style="min-width: 100px" class="left-align"><b>Tentage (Rebate)</b></td>
                <td style="min-width: 100px" class="left-align"><b>Catering (Rebate)</b></td>
                <td style="min-width: 100px" class="left-align"><b>Electricity (Rebate)</b></td>
                <td style="min-width: 100px" class="left-align"><b>CGST (%)</b></td>
                <td style="min-width: 100px" class="left-align"><b>CGST (Amt)</b></td>
                <td style="min-width: 100px" class="left-align"><b>SGST (%)</b></td>
                <td style="min-width: 100px" class="left-align"><b>SGST (Amt)</b></td>
                <td style="min-width: 100px" class="left-align"><b>Total Amount</b></td>
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
                <td class="left-align">{{ $value->rebate_safai }}</td>
                <td class="left-align">{{ $value->rebate_tentage }}</td>
                <td class="left-align">{{ $value->rebate_catering }}</td>
                <td class="left-align">{{ $value->rebate_electricity }}</td>
                <td class="left-align">{{ $value->servicetax_percentage }}</td>
                <td class="left-align">{{ $value->servicetax_amount }}</td>
                <td class="left-align">{{ $value->vat_percentage }}</td>
                <td class="left-align">{{ $value->vat_amount }}</td>
                <td class="left-align">{{ $value->total_amount }}</td>
              </tr>
              @endforeach
			  <?php }?>
            </tbody>
          </table>
      </div>
	  @endif
	</div>
</div>
</div>
@endsection