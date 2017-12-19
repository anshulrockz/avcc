@extends('layouts.website')

@section('content')
<script src="{{url('/js/modernizr.custom.js')}}"></script>
<style>
.my-toggle-class {
color: #888;
cursor: pointer;
font-size: 0.75em;
font-weight: bold;
padding: 0.5em 1em;
text-transform: uppercase;
}
</style>
<div class="pageheader">
		<div class="media">
        <div class="pageicon pull-left">
            <i class="fa fa-gear"></i>
        </div>
        <div class="media-body">
    	<h4>Change Password</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Change Password</li>
        </ul>
    	</div>
    </div><!-- media -->
</div><!-- pageheader -->
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
        <div class="col-md-5">
          @if(Session::has('success'))
			<div class="alert alert-success">
				{{ Session::get('success') }}
			 </div>
		  @endif
          @if(Session::has('failed'))
			<div class="alert alert-danger">
				<ul>
			       <li>{{ Session::get('failed') }}</li>
			    </ul>
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
          <form method="post" action="{{url('/changepassword')}}">
          	{{ csrf_field() }}
		    <div class="form-group">
		      <label>*Old Password:</label>
		      <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Enter old password" required="">
		    </div>
		    <div class="form-group">
		      <label>*New Password:</label>
		      <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password" required="">
		    </div>
		    <div class="form-group">
		      <label>*Confirm New Password:</label>
		      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required="">
		    </div>
		    <button type="submit" name="submit" class="btn btn-primary">Update</button>
		  </form>
        </div>
    </div>
</div>
</div>
<!-- Include the plugin. Yay! --> 
<script src="{{url('/js/hideShowPassword.min.js')}}"></script> 
<script>
// Example 2
$('#old_password,#password,#confirm_password').hideShowPassword({
  // Make the password visible right away.
  show: false,
  // Create the toggle goodness.
  innerToggle: true,
  // Give the toggle a custom class so we can style it
  // separately from the previous example.
  toggleClass: 'my-toggle-class',
  // Don't show the toggle until the input triggers
  // the 'focus' event.
  hideToggleUntil: 'focus',
  // Enable touch support for toggle.
  touchSupport: Modernizr.touch
});
</script>
@endsection