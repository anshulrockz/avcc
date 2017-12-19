@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="media-body">
		<h4>{{$client_name[0]->name}}</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Client Account</li>
		    <li>{{$client_name[0]->name}}</li>
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
		      	<th>Date</th>
		        <th>Particular</th>
		        <th>Debit</th>
		        <th>Credit</th>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($clientaccount as $value)
	          <tr>
	            <td>{{ date_dfy($value->created_at) }}</td>
	            <td>{{ $value->particular }}</td>
	            <td>{{ zero_empty(slash_decimal($value->debit)) }}</td>
	            <td>{{ zero_empty(slash_decimal($value->credit)) }}</td>
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