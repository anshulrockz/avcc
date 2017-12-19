@if(Session::has('success'))
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ Session::get('error') }}</strong>
</div>
@endif

@if(Session::has('warning'))
<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ Session::get('warning') }}</strong>
</div>
@endif

@if(Session::has('info'))
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ Session::get('info') }}</strong>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<ul>
       @foreach ($errors->all() as $error)
          <li><strong>{{ $error }}</strong></li>
       @endforeach
    </ul>
</div>
@endif