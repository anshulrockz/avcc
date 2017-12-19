@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Add Bank</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/bank') }}">Bank</a></li>
            <li>Add</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-6">
		@include('flashmessage')
      	<form method="post" action="{{ url('bank/save') }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Bank Name:</label>
		    <input type="text" class="form-control" placeholder="Enter bank name" name="name" id="name" required="">
		  </div>
		  <div class="form-group">
		    <label>IFSC:</label>
		    <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc" id="ifsc">
		  </div>
		  <div class="form-group">
		    <label>Account No:</label>
		    <input type="text" class="form-control" placeholder="Enter account number" name="account_no" id="account_no">
		  </div>
		  <div class="form-group">
		    <label>Address 1:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address1" id="address1">
		  </div>
		  <div class="form-group">
		    <label>Address 2:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address2" id="address2">
		  </div>
		  <div class="form-group">
		    <label>Address 3:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address3" id="address3">
		  </div>
		  <div class="form-group">
		    <label>City:</label>
		    <input type="text" class="form-control" placeholder="Enter city" name="city" id="city">
		  </div>
		  <div class="form-group">
		    <label>Contact Person:</label>
		    <input type="text" class="form-control" placeholder="Enter contact person" name="contact_person" id="contact_person">
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
      </div>
	</div>
</div>
</div>
@endsection