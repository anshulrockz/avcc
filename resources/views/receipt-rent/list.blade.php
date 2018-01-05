@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="pull-right">
			<a href="{{ url('/receipt-rent/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Create Receipt</button></a>
		</div>
		<div class="media-body">
		<h4>Rent Receipts</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Receipt</li>
		    <li>Rent Receipts</li>
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
		      	<th>Party Name</th>
		      	<th>Rent Premises</th>
		      	<th>Rent ATM</th>
		        <th>Rent Store</th>
		        <th>TDS</th>
		        <th>CGST</th>
		        <th>SGST</th>
		        <th>Status</th>
		        <?php if(Auth::user()->user_group == '1'){ ?>
		        <th style="width: 100px">Action</th>
		        <?php }?>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($receipt as $value)
		      @php
		      $with_tax = $tax_check::tax_check($value->parent_id);
		      $cgst_percentage = 0;
			  $sgst_percentage = 0;
			  if($with_tax >0){
				$cgst_percentage = $global_st;
				$sgst_percentage = $global_vat;
			  }
		      $tds = $value->tds;
		      $rent_premises = $value->rent_premises;
		      $rent_store = $value->rent_store;
		      $rent_atm = $value->rent_atm;
		      $total_cgst = round($rent_premises*$cgst_percentage/100+$rent_store*$cgst_percentage/100+$rent_atm*$cgst_percentage/100);
		      $total_sgst = round($rent_premises*$sgst_percentage/100+$rent_store*$sgst_percentage/100+$rent_atm*$sgst_percentage/100);
		      $total_before_tax = $rent_premises+$rent_store+$rent_atm;
		      $tds_amount = $total_before_tax*$tds/100;
		      
      		  @endphp
	          <tr>
	          	<td>{{ $value->party_name }}</td>
	          	<td>{{ $value->rent_premises }}</td>
	            <td>{{ $value->rent_atm }}</td>
	            <td>{{ $value->rent_store }}</td>
	            <td>{{ $tds_amount }}</td>
	            <td>{{ $total_cgst }}</td>
	            <td>{{ $total_sgst }}</td>
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