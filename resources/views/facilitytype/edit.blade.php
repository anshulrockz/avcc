@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Facility Type</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/facilitytype') }}">Facility Type</a></li>
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
      	<form method="post" action="{{ url('/facilitytype/update/'.$facilitytype[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo $facilitytype[0]->name; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>Description:</label>
		    <textarea rows="4" class="form-control" placeholder="Enter description" name="description" id="description" maxlength="400"><?php echo $facilitytype[0]->description; ?></textarea>
		  </div>
		  <div style="text-align: right" id="description_characters"></div>
		  <button type="submit" class="btn btn-primary">Update</button>
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