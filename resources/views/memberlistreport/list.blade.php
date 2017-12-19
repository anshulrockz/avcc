@extends('layouts.website')
@section('content')
<script>
	function printPage(){
		window.print();
	}
</script>
<div class="pageheader">
	<div class="media">
		<div class="pull-right">
			<button onclick="printPage();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
		</div>
		<div class="media-body">
		<h4>Member List Report</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Reports</li>
		    <li>Member List Report</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" method="post" action="">
			{{ csrf_field() }}
				<div class="form-group" style="margin-right: 0">
					<select class="form-control" name="member_type" id="member_type">
					  <option value="">Member Type</option>
					  @foreach($member_type as $value)
					  <option value="{{$value->id}}" <?php if($membertype_name==$value->name){ ?> selected="" <?php }?>>{{$value->name}}</option>
					  @endforeach
					</select>
					<input type="number" name="sector" id="sector" value="{{$sector}}" class="form-control" placeholder="Sector"/>
				</div>
				<button type="submit" name="submit" class="btn btn-info">Find</button>
			</form>
		</div>
	</div>           
    <div class="row" style="margin-top: 10px">
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
		  <h4 class="center onlyprint">ARUN VIHAR COMMUNITY CENTER </h4>
		  <h5 class="center onlyprint">SECTOR 37, NOIDA</h5>
		  <h4 class="center-underline onlyprint">Member List Report</h4>
		  @if($_POST && $_POST>0)
		  	@if($_POST['member_type'] && $_POST['sector'])
		  	<h5 class="center-print"><strong>Member Type: {{$membertype_name}}, Sector: {{$sector}}</strong></h5>
		  	@else
		  		@if($_POST['member_type'])
		  		<h5 class="center-print"><strong>Member Type: {{$membertype_name}}</strong></h5>
		  		@elseif($_POST['sector'])
		  		<h5 class="center-print"><strong>Sector: {{$sector}}</strong></h5>
		  		@endif
		  	@endif
		  @endif
		  <div class="table-responsive">
		  <table class="table table-bordered" style="border: 1px solid #ddd; margin-top: 15px">
		    <thead>
		      <tr>
		      	<th>S.No</th>
		        <th>Name</th>
		        <th>Membership No</th>
		        <th>Member Type</th>
		        <th>Address</th>
		        <th style="max-width: 60px">Sector</th>
		        <th>City</th>
		        <th>Mobile</th>
		        <th>Phone</th>
		        <th>Email</th>
		      </tr>
		    </thead>
		    <tbody>
		      <?php $i=1; foreach ($member as $value){ ?>
	          <tr>
	          	<td>{{$i}}</td>
	            <td>{{ $value->name }}</td>
	            <td>{{ $value->membership_no }}</td>
	            <td>{{ $value->membertype_name }}</td>
	            <td>{{ $value->address }}</td>
	            <td>{{ $value->sector }}</td>
	            <td>{{ $value->city }}</td>
	            <td>{{ $value->mobile }}</td>
	            <td>{{ $value->phone }}</td>
	            <td>{{ $value->email }}</td>
	          </tr>
	          <?php $i++; } ?>
		    </tbody>
		  </table>
		  </div>
		<?php } else{?>
		<p>No results found!</p>
		<?php }?>
		</div>
	</div>
</div>
</div>
@endsection