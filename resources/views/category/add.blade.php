@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Add Category</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/category') }}">Category</a></li>
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
      	<form method="post" action="{{ url('category/save') }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		      <label>Parent:</label>
		      <select class="form-control" name="parent" id="parent">
		      		<option value="0">None</option>
		      		@foreach ($parent as $value)
		      		<option value="{{ $value->id }}">{{ $value->slug }}</option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		      <label>*Company:</label>
		      <select class="form-control" name="company" id="company" required="">
		      		<option value="">Select</option>
		      		@foreach ($company as $value)
		      		<option value="{{ $value->id }}">{{ $value->name }}</option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" required="">
		  </div>
		  <div class="form-group">
		    <label>Description:</label>
		    <textarea rows="4" class="form-control" placeholder="Enter description" name="description" id="description" maxlength="400"></textarea>
		  </div>
		  <div style="text-align: right" id="description_characters"></div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
      </div>
	</div>
</div>
</div>
<script>
$(document).ready(function() {
    var text_max = 400;
    var text_length = $('#description').val().length;
    var text_remaining = text_max - text_length;
    $('#description_characters').html(text_remaining + ' characters left');

    $('#description').keyup(function() {
        var text_length = $('#description').val().length;
        var text_remaining = text_max - text_length;

        $('#description_characters').html(text_remaining + ' characters left');
    });
});
</script>
@endsection