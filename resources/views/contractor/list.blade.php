@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/contractor/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Contractor</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Contractor</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Masters</li>
		    <li>Contractor</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    @include('flashmessage')
		<?php if($count>0){ ?>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		        <th>Name</th>
		        <th>Phone</th>
		        <th>Mobile</th>
		        <th>Address 1</th>
		        <th>Address 2</th>
		        <th>Address 3</th>
		        <th>Opening Balance</th>
		        <th>Op.Balance Date</th>
		        <th>Rebate (%)</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th>Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($contractor as $value)
	          <tr>
	            <td>{{ $value->name }}</td>
	            <td>{{ $value->phone }}</td>
	            <td>{{ $value->mobile }}</td>
	            <td>{{ $value->address1 }}</td>
	            <td>{{ $value->address2 }}</td>
	            <td>{{ $value->address3 }}</td>
	            <td>{{ slash_decimal($value->op_balance) }}</td>
	            <td>{{ date_dfy($value->opbalance_date) }}</td>
	            <td>{{ zero_empty($value->rebate) }}</td>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/contractor/edit/'.$value->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
	            <a onclick="return confirm('Are you sure you want to Delete?');" href="{{ url('/contractor/delete/'.$value->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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