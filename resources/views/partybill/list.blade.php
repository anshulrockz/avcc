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
		<h4>Party Bill</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Reports</li>
		    <li>Party Bill</li>
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
		  <h4 class="center onlyprint">ARUN VIHAR COMMUNITY CENTER </h4>
		  <h5 class="center onlyprint">SECTOR 37, NOIDA</h5>
		  <h4 class="center-underline onlyprint">Party Bill</h4>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		      	<th>S.No</th>
		        <th>Name</th>
		        <th>Membership No</th>
		        <th>Member Type<br />
		        <select class="form-control input-sm" id="filter1" style="margin-top: 10px">
				  <option value="">Select</option>
				  @foreach($member_type as $value)
				  <option value="{{$value->name}}">{{$value->name}}</option>
				  @endforeach
				</select>
		        </th>
		        <th>Address</th>
		        <th style="max-width: 60px">Sector<br />
		        <input type="number" class="form-control input-xs" id="filter2"/>
		        </th>
		        <th>City</th>
		        <th>Mobile</th>
		        <th>Email</th>
		      </tr>
		    </thead>
		    <tbody>
		      <?php $i=1; foreach ($member as $value){ ?>
	          <tr>
	          	<td>{{$i}}</td>
	            <td>{{ $value->name }}</td>
	            <td>{{ $value->id }}</td>
	            <td>{{ $value->membertype_name }}</td>
	            <td>{{ $value->address }}</td>
	            <td>{{ $value->sector }}</td>
	            <td>{{ $value->city }}</td>
	            <td>{{ $value->mobile }}</td>
	            <td>{{ $value->email }}</td>
	          </tr>
	          <?php $i++; } ?>
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
    	"ordering": false,
    	dom: 'ltip'
    });
    var table =  $('#dataTable').DataTable();
    $('#filter1').on('change', function () {
        table.columns(3).search( this.value ).draw();
    } );
    $('#filter2').keyup(function () {
        table.columns(5).search( this.value ).draw();
    } );
});
</script>
@endsection