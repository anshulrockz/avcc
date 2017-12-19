@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/bank/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Bank</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Bank</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Masters</li>
		    <li>Bank</li>
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
		        <th>IFSC</th>
		        <th>Account No</th>
		        <th>Address 1</th>
		        <th>Address 2</th>
		        <th>Address 3</th>
		        <th>City</th>
		        <th>Contact Person</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th>Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($bank as $value)
	          <tr>
	            <td>{{ $value->name }}</td>
	            <td>{{ $value->ifsc }}</td>
	            <td>{{ $value->account_no }}</td>
	            <td>{{ $value->address1 }}</td>
	            <td>{{ $value->address2 }}</td>
	            <td>{{ $value->address3 }}</td>
	            <td>{{ $value->city }}</td>
	            <td>{{ $value->contact_person }}</td>
	            <?php if(Auth::user()->user_group == '1'){ ?>
	            <td>
	            <a href="{{ url('/bank/edit/'.$value->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
	            <a onclick="return confirm('Are you sure you want to Delete?');" href="{{ url('/bank/delete/'.$value->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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