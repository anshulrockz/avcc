@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Company</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{url('/company')}}">Company</a></li>
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
      	<form method="post" action="{{ url('/company/update/'.$company[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo $company[0]->name; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>*Address:</label>
		    <textarea rows="4" class="form-control" placeholder="Enter address" name="address" id="address" maxlength="400" required=""><?php echo $company[0]->address; ?></textarea>
		  </div>
		  <div style="text-align: right" id="address_characters"></div>
		  <div class="form-group">
		    <label>Phone:</label>
		    <input type="text" class="form-control" placeholder="Enter phone" name="phone" id="phone" value="<?php echo $company[0]->phone; ?>">
		  </div>
		  <div class="form-group">
		    <label>Mobile:</label>
		    <input type="text" class="form-control" placeholder="Enter mobile" name="mobile" id="mobile" pattern="[0-9]{10}" title="Please enter 10 digit mobile number" value="<?php echo $company[0]->mobile; ?>" maxlength="10">
		  </div>
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>
		</div>
	</div>
</div>
</div>
<script>
$(document).ready(function() {
    var text_max = 400;
    var text_length = $('#address').val().length;
    var text_remaining = text_max - text_length;
    $('#address_characters').html(text_remaining + ' characters left');

    $('#address').keyup(function() {
        var text_length = $('#address').val().length;
        var text_remaining = text_max - text_length;

        $('#address_characters').html(text_remaining + ' characters left');
    });
});
</script>
@endsection