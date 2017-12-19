@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/debit-voucher/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Create Debit Voucher</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Debit Voucher</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Debit Voucher</li>
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
		        <th>R.V No</th>
		        <th>R.V Date</th>
		        <th>Party Name</th>
		        <th>Function Date</th>
		        <th>Cheque No</th>
		        <th>Cheque Date</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th width="150px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($debitvoucher as $value)
	          <tr>
	            <td>{{ $value->id }}</td>
	            <td>{{ date_dfy($value->voucher_date) }}</td>
	            <td>{{ $value->rv_no }}</td>
	            <td>{{ date_dfy($value->rv_date) }}</td>
	            <td>{{ $value->party_name }}</td>
	            <td>{{ date_dfy($value->function_date) }}</td>
	            <td>{{ $value->cheque_no }}</td>
	            <td>{{ date_dfy($value->cheque_date) }}</td>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/debit-voucher/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
	            <a href="{{ url('/debit-voucher/edit/'.$value->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
	            <a onclick="return confirm('Are you sure you want to Delete?');" href="{{ url('/debit-voucher/delete/'.$value->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
	            </td>
	            <?php }?>
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
    });
});
</script>
@endsection