@extends('layouts.website')

@section('content')

<div class="pageheader">
		<div class="media">
        <div class="pageicon pull-left">
            <i class="fa fa-user"></i>
        </div>
        <div class="media-body">
    	<h4>Edit Profile</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Edit Profile</li>
        </ul>
    	</div>
    </div><!-- media -->
</div><!-- pageheader -->
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
        <div class="col-md-5">
          @if(Session::has('status'))
			<div class="alert alert-success">
				{{ Session::get('status') }}
			 </div>
		  @endif
          @if (count($errors) > 0)
			 <div class="alert alert-danger">
			    <ul>
			       @foreach ($errors->all() as $error)
			          <li>{{ $error }}</li>
			       @endforeach
			    </ul>
			 </div>
		  @endif
          <form method="post" action="{{url('/editprofile')}}" enctype="multipart/form-data">
          	{{ csrf_field() }}
		    <div class="form-group">
		      <label>*Name:</label>
		      <input type="text" class="form-control" name="name" id="name" value="<?php echo $profile[0]->name; ?>" placeholder="Enter your name" required="">
		    </div>
		    <div class="form-group">
		      <label>*Email:</label>
		      <input type="email" class="form-control" name="email" id="email" value="<?php echo $profile[0]->email; ?>" placeholder="Enter your email" required="">
		    </div>
		    <div class="form-group">
		      <label>*Mobile:</label>
		      <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $profile[0]->mobile; ?>" placeholder="Enter your mobile (10 digits only)" required="" maxlength="10">
		    </div>
		    <div class="form-group">
		      <label>Image:</label>
		      <input class="form-control" type="file" name="image" accept="image/*" />
		      <?php if($profile[0]->image != ''){ ?>
	          <img style="margin-top: 10px" width="100px" src="{{url('/uploads/'.$profile[0]->image)}}"/>
	          <?php } ?>
		    </div>
		    <button type="submit" name="submit" class="btn btn-primary">Update</button>
		  </form>
        </div>
    </div>
</div>
</div>

@endsection