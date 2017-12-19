@extends('layouts.website')
@section('content')
<script type='text/javascript'>
$(function(){
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
$('.input-group.date').datepicker({
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true,
    format: "dd-MM-yyyy",
    //startDate: today
});  
});
</script>
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Account Head</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/accounthead') }}">Account Head</a></li>
            <li>Edit</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-6">
		@include('flashmessage')
      	<form method="post" action="{{ url('/accounthead/update/'.$accounthead[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo $accounthead[0]->name; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>Opening Balance:</label>
		    <input type="number" class="form-control" placeholder="Enter opening balance" name="op_balance" id="op_balance" value="<?php echo slash_decimal($accounthead[0]->op_balance); ?>">
		  </div>
		  <div class="form-group">
		      <label>Op.Balance Date:</label>
			  <div class="input-group date">
				<input type="text" name="opbalance_date" id="opbalance_date" value="<?php echo date_dfy($accounthead[0]->opbalance_date); ?>" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>
		</div>
	</div>
</div>
</div>
@endsection