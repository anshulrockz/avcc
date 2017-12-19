@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/member/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Member</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Member</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Member</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    @include('flashmessage')
	    <a href="{{ URL::to('downloadMember/xlsx') }}"><button class="btn btn-info">Download Excel xlsx</button></a>
	    <br /><br />
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		      	<th>Membership No</th>
                <th>Member Type</th>
		        <th>Name</th>
		        <th>Mobile</th>
		        <th>Email</th>
		        <th>Address</th>
		        <th>Sector</th>
		        <th>City</th>
		        <th>Op.Sec Amt</th>
		        <th>Op.Sec Amt Date</th>
		        <th style="min-width:100px">Action</th>
		      </tr>
		    </thead>
		    <!--<tbody>
		    	<tr>
		    		<td>Hello</td>
		    	</tr>
		    </tbody>-->
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
        "ajax": "{{ route('datatable.getMembers') }}",
        "columns": [
            {data: 'membership_no', name: 'membership_no'},
            {data: 'membertype_name', name: 'membertype_name'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            {data: 'sector', name: 'sector'},
            {data: 'city', name: 'city'},
            {data: 'opsec_amt', name: 'opsec_amt'},
            {data: 'opsecamt_date', name: 'opsecamt_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<!--<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
    	dom: 'Bfrtip',
        buttons: [
        	{
                extend: 'excelHtml5',
                title: 'Member',
                text: 'Export Data to Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                }
            },
        ]
    });
});
</script>-->
@endsection