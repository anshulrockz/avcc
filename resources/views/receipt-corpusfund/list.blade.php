@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="pull-right">
			<a href="{{ url('/receipt-corpusfund/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Create Receipt</button></a>
		</div>
		<div class="media-body">
		<h4>Corpus Fund Receipts</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Receipt</li>
		    <li>Corpus Fund Receipts</li>
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
		@if (count($errors) > 0)
		 <div class = "alert alert-danger">
		    <ul>
		       @foreach ($errors->all() as $error)
		          <li>{{ $error }}</li>
		       @endforeach
		    </ul>
		 </div>
		@endif
		<?php if($count>0){ ?>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		      	<th>Bank Name</th>
		      	<th>Receipt No</th>
		        <th>Corpus Fund</th>
		        <th>Payment Mode</th>
		        <th>Status</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th style="width: 100px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($receipt as $value)
		      <tr>
	          	<td>{{ $value->party_name }}</td>
	          	<td>{{ $value->receipt_no }}</td>
	            <td>{{ $value->corpus_fund }}</td>
	            <td>{{ $value->payment_mode }}</td>
	            <?php if($value->status == '1'){ ?>
	            <td><span class="label label-success">Active</span></td>
	            <?php }?>
	            <?php if($value->status == '2'){ ?>
	            <td><span class="label label-warning">Cancelled</span></td>
	            <?php }?>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/receipt/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
	            <?php if($value->status == '1'){ ?>
	            <a onclick="return confirm('Are you sure you want to Cancel?');" href="{{ url('/receipt/cancel/'.$value->id) }}" data-toggle="tooltip" title="Cancel" class="btn btn-danger" data-original-title="Cancel"><i class="fa fa-times"></i></a>
	            <?php }?>
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
    	"ordering": false
    });
});
</script>
@endsection