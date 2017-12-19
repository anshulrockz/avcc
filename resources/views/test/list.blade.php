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
		<h4>Test</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Test</li>
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
		  <h4 class="center onlyprint">ARUN VIHAR COMMUNITY CENTER </h4>
		  <h5 class="center onlyprint">SECTOR 37, NOIDA</h5>
		  <h4 class="center-underline onlyprint">Test</h4>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		      	<th>S.No</th>
		        <th>Name</th>
		        <th>Booking Date</th>
		      </tr>
		    </thead>
		  </table>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('datatable.getdata') }}",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'booking_date', name: 'booking_date'}
        ]
    });
});
</script>
@endsection