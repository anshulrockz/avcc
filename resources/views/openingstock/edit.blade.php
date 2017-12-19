@extends('layouts.website')
@section('content')
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
    	<h4>Update Opening Stock</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{url('/openingstock')}}">Opening Stock</a></li>
            <li>edit</li>
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
      	<form method="post" action="{{ url('/openingstock/update/'.$openingstock[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		      <label>*Company:</label>
		      <select class="form-control" name="company" id="company" onChange="getCategory(this.value);" required="">
		      		@foreach ($company as $value)
		      		<option value="<?php echo $value->id; ?>" <?php if($openingstock[0]->company_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
			<label>*Category:</label>
			  <select class="form-control" name="category" id="category" onChange="getItems(this.value);" required="">
			  	@foreach ($category as $value)
	      		<option value="<?php echo $value->id; ?>" <?php if($category_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
	      		@endforeach
			  </select>
		  </div>
		  <div class="form-group">
		      <label>*Item:</label>
		      <select class="form-control" name="item" id="item" required="">
		      		@foreach ($item as $value)
		      		<option value="<?php echo $value->id; ?>" <?php if($openingstock[0]->item_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		    <label>*Quantity:</label>
		    <input type="number" class="form-control" placeholder="Enter quantity" name="quantity" id="quantity" value="{{$openingstock[0]->quantity}}" min="1" required="">
		  </div>
		  <div class="form-group">
		    <label>*Rate:</label>
		    <input type="number" class="form-control" placeholder="Enter rate" name="rate" id="rate" value="{{$openingstock[0]->rate}}" min="1" required="">
		  </div>
		  <div class="form-group">
		      <label>*Date:</label>
			  <div class="input-group date">
				<input type="text" name="on_date" id="on_date" value="<?php echo date_dfy($openingstock[0]->on_date); ?>" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>
		</div>
	</div>
</div>
</div>
@endsection