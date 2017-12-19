@extends('layouts.website')
@section('content')
<?php
$date = date("Y-m-d H:i:s", time());
$on_date = date("d-F-Y");
?>
<script>
function getCategory(val) {
	$.ajax({
	type: "GET",
	url: "{{url('/openingstock/ajax')}}",
	data:'company_id='+val,
	success: function(data){
		$("#category").html(data);
		$("#item").html('<option value="">Select</option>');
	}
	});
}
function getItems(val) {
	$.ajax({
	type: "GET",
	url: "{{url('/openingstock/ajax2')}}",
	data:'category_id='+val,
	success: function(data){
		$("#item").html(data);
	}
	});
}
</script>
<script type='text/javascript'>
$(function(){
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0); 
$('.input-group.date').datepicker({
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true,
    format: "dd-MM-yyyy",
    startDate: today
});  
});
</script>
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Add Opening Stock</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/openingstock') }}">Opening Stock</a></li>
            <li>add</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-6">
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
      	<form method="post" action="{{ url('openingstock/save') }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		      <label>*Company:</label>
		      <select class="form-control" name="company" id="company" onChange="getCategory(this.value);" required="">
		      		<option value="">Select</option>
		      		@foreach ($company as $value)
		      		<option value="{{ $value->id }}">{{ $value->name }}</option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		      <label>*Category:</label>
		      <select class="form-control" name="category" id="category" onChange="getItems(this.value);" required="">
		      		<option value="">Select</option>
		      </select>
		  </div>
		  <div class="form-group">
		      <label>*Item:</label>
		      <select class="form-control" name="item" id="item" required="">
		      		<option value="">Select</option>
		      </select>
		  </div>
		  <div class="form-group">
		    <label>*Quantity:</label>
		    <input type="number" class="form-control" placeholder="Enter quantity" name="quantity" id="quantity" min="1" required="">
		  </div>
		  <div class="form-group">
		    <label>*Rate:</label>
		    <input type="number" class="form-control" placeholder="Enter rate" name="rate" id="rate" min="1" required="">
		  </div>
		  <div class="form-group">
		      <label>*Date:</label>
			  <div class="input-group date">
				<input type="text" name="on_date" id="on_date" value="{{$on_date}}" class="form-control" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
      </div>
	</div>
</div>
</div>
@endsection