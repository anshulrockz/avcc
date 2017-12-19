@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>View Debit Voucher</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Voucher</li>
            <li><a href="{{ url('/debit-voucher') }}">Debit Voucher</a></li>
            <li>View</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-8">
		  <div class="table-responsive">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="4">Debit Voucher</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
	                <td width="150px" class="facility-td"><b>Voucher ID:</b></td>
	                <td class="facility-td">{{$voucher[0]->id}}</td>
	                <td width="150px" class="facility-td"><b>Voucher Date:</b></td>
	                <td class="facility-td">{{date_dfy($voucher[0]->voucher_date)}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>R.V No:</b></td>
	                <td class="facility-td">{{$voucher[0]->rv_no}}</td>
	                <td width="150px" class="facility-td"><b>R.V Date:</b></td>
	                <td class="facility-td">{{date_dfy($voucher[0]->rv_date)}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Party Name:</b></td>
	                <td class="facility-td">{{$voucher[0]->party_name}}</td>
	                <td class="facility-td"><b>Function Date:</b></td>
	                <td class="facility-td">{{date_dfy($voucher[0]->function_date)}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Cheque No:</b></td>
	                <td class="facility-td">{{$voucher[0]->cheque_no}}</td>
	                <td class="facility-td"><b>Cheque Date:</b></td>
	                <td class="facility-td">{{date_dfy($voucher[0]->cheque_date)}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>A/C Head:</b></td>
	                <td class="facility-td">{{$voucher[0]->achead_name}}</td>
	                <td class="facility-td"><b>Paid To:</b></td>
	                <td class="facility-td">{{$voucher[0]->contractor_name}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Security Amount:</b></td>
	                <td class="facility-td">{{$voucher[0]->security_amount}}</td>
	                <td class="facility-td"><b>Remarks:</b></td>
	                <td class="facility-td">{{$voucher[0]->remarks}}</td>
	              </tr>
	            </tbody>
	          </table>
          </div>
      	</div>
	</div>
</div>
</div>
@endsection