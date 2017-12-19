@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="media-body">
		<h4>All Receipts</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Receipt</li>
		    <li>All Receipts</li>
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
		      	<th>Receipt No</th>
		      	<th>Receipt Date</th>
		      	<th>Booking No</th>
		      	<th>Party Name</th>
		        <th>Payment Mode</th>
		        <th>Receipt Type</th>
		        <th>Status</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th style="width: 100px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($receipt as $value)
	          <tr>
	            <td>{{ $value->id }}</td>
	            <td>{{ date_dfy($value->created_at) }}</td>
	            <td>{{ $value->booking_no }}</td>
	            <td>{{ $value->party_name }}</td>
	            <td>{{ $value->payment_mode}}</td>
	            <td>
	            <?php
	            if($value->receipt_type == '1'){
					$receipt_type = 'Booking';
					$label_color = 'primary';
				}
				elseif($value->receipt_type == '2'){
					$receipt_type = 'CGST Liability';
					$label_color = 'warning';
				}
				elseif($value->receipt_type == '3'){
					$receipt_type = 'Tentage & Catering';
					$label_color = 'success';
				}
				elseif($value->receipt_type == '4'){
					$receipt_type = 'Others';
					$label_color = 'info';
				}
				elseif($value->receipt_type == '5'){
					$receipt_type = 'Rent';
					$label_color = 'info';
				}
				elseif($value->receipt_type == '6'){
					$receipt_type = 'FD';
					$label_color = 'info';
				}
				else{
					$receipt_type = '';
				}
	            ?>
	            <?php if($receipt_type !=''){ ?>
	            <span class="label label-{{$label_color}}">{{$receipt_type}}</span>
	            <?php }?>
	            </td>
	            <?php if($value->receipt_status == '1'){ ?>
	            <td><span class="label label-success">Active</span></td>
	            <?php }?>
	            <?php if($value->receipt_status == '2'){ ?>
	            <td><span class="label label-warning">Cancelled</span></td>
	            <?php }?>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/receipt/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
	            <?php if($value->receipt_status == '1'){ ?>
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