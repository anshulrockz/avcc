@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/refund-voucher/partialcancel') }}"><button class="btn btn-primary"><i class="fa fa-scissors"></i> Partial Cancellation</button></a>
			<a href="{{ url('/refund-voucher/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Others</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Refund Voucher</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Refund Voucher</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    @if(Session::has('success'))
	    <div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  {{ Session::get('success') }}
		</div>
		@endif
		@if(Session::has('failed'))
		<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ Session::get('failed') }}
		</div>
		@endif
		<?php if($count>0){ ?>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		        <th>Voucher ID</th>
		        <th>Voucher Date</th>
		        <th>Receipt No</th>
		        <th>Payment Mode</th>
		        <th>Refund Type</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th width="50px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($refundvoucher as $value)
	          <tr>
	            <td>{{ $value->id }}</td>
	            <td>{{ date_dfy($value->voucher_date) }}</td>
	            <td>{{ $value->receipt_id }}</td>
	            <td>{{ $value->payment_mode }}</td>
	            @if($value->refund_type == '1')
	            <td><span class="badge">Full Cancellation</span></td>
	            @elseif($value->refund_type == '2')
	           <td><span class="badge">Security Refund</span></td>
	            @elseif($value->refund_type == '3')
	            <td><span class="badge">Partial Cancellation</span></td>
	            @endif
	            <td>
	            <a href="{{ url('/refund-voucher/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
	            </td>
	          </tr>
	          @endforeach
		    </tbody>
		  </table>
		<?php } else{?>
		<p>No results found!</p>
		<?php }?>
		</div>
	</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
    	ordering:false
    });
});
</script>
@endsection