@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="media-body">
		<h4>Tax Liability</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Tax Liability</li>
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
		        <th>Booking Form No</th>
		      	<th>Party Name</th>
		      	<th>Function Date</th>
		      	<th>Function Time</th>
		        <th>Function Type</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th style="width: 50px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($booking as $value)
	          <tr>
	            <td>{{ $value->booking_no }}</td>
	          	<td>{{ $value->party_name }}</td>
	          	<td>{{ date_dfy($value->function_date) }}</td>
	            <td>{{ am_pm($value->from_time).' - '. am_pm($value->to_time)}}</td>
	            <td>{{ $value->function_type }}</td>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/receipt-stl/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
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