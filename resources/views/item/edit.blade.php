@extends('layouts.website')
@section('content')
<script>
function getCategory(val) {
	$.ajax({
	type: "GET",
	url: "{{url('/item/ajax')}}",
	data:'company_id='+val,
	success: function(data){
		$("#beforeajax_data").hide();
		$("#ajax_data").html(data);
	}
	});
}
</script>
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Item</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{url('/item')}}">Item</a></li>
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
      	<form method="post" action="{{ url('/item/update/'.$item[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		      <label>*Company:</label>
		      <select class="form-control" name="company" id="company" onChange="getCategory(this.value);" required="">
		      		@foreach ($company as $value)
		      		<option value="<?php echo $value->id; ?>" <?php if($item[0]->company_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo $item[0]->name; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>Description:</label>
		    <textarea rows="4" class="form-control" placeholder="Enter description" name="description" id="description" maxlength="400"><?php echo $item[0]->description; ?></textarea>
		  </div>
		  <div style="text-align: right" id="description_characters"></div>
		  <div class="form-group">
		    <label>*Price:</label>
		    <input type="number" class="form-control" placeholder="Enter price" name="price" id="price" value="<?php echo $item[0]->price; ?>" required="" min="1" step="1">
		  </div>
		  <div id="beforeajax_data">
		  <div class="form-group">
			<label>*Category:</label>
			  <select class="form-control" name="category" id="category">
			  	@foreach ($category as $value)
	      		<option value="<?php echo $value->id; ?>" <?php if($item[0]->category_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
	      		@endforeach
			  </select>
		  </div>
		  <div class="form-group">
			<label>*Unit:</label>
			  <select class="form-control" name="unit" id="unit">
			  	@foreach ($unit as $value)
	      		<option value="<?php echo $value->id; ?>" <?php if($item[0]->unit_id==$value->id){ ?> selected="" <?php }?>><?php echo $value->name; ?></option>
	      		@endforeach
			  </select>
		  </div>
		  </div>
		  <div id="ajax_data"></div>
		  <div class="form-group">
			<label>Tax:</label>
			  <div class="form-group">
				  <div>
				  	<?php if(count($tax)>0){ ?>
				  	@foreach ($tax as $value)
					  <label class="checkbox-inline"><input type="checkbox" name="taxes[]" value="<?php echo $value->id; ?>"<?php foreach($item_tax as $value1){ $p_tax = $value1->tax_id; if($value->id==$p_tax){ echo "checked"; } } ?>><?php echo $value->name; ?></label>
					@endforeach
					<?php } else{ ?>
					  <label class="checkbox-inline"><input type="checkbox" name="taxes[]" checked="" disabled="">Tax Free</label>
					<?php } ?>
				  </div>
			  </div>
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