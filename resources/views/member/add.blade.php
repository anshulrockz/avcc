@extends('layouts.website')
@section('content')
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
    	<h4>Add Member</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/member') }}">Member</a></li>
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
      	<form method="post" action="{{ url('member/save') }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Membership No:</label>
		    <input type="number" class="form-control" placeholder="Enter memebership no" name="membership_no" id="membership_no" required="">
		  </div>
		  <div class="form-group">
		      <label>*Member Type:</label>
		      <select class="form-control" name="member_type" id="member_type" required="">
		      		<option value="">Select</option>
		      		@foreach ($membertype as $value)
		      		<option value="{{ $value->id }}">{{ $value->name }}</option>
		      		@endforeach
		      </select>
		  </div>
		  <div class="form-group">
		    <label>*Member Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" required="">
		  </div>
		  <div class="form-group">
		    <label>Phone:</label>
		    <input type="text" class="form-control" placeholder="Enter phone" name="phone" id="phone">
		  </div>
		  <div class="form-group">
		    <label>Mobile:</label>
		    <input type="text" class="form-control" placeholder="Enter mobile" name="mobile" id="mobile">
		  </div>
		  <div class="form-group">
		    <label>Email:</label>
		    <input type="email" class="form-control" placeholder="Enter email" name="email" id="email">
		  </div>
		  <div class="form-group">
		      <label>Expiry Date:</label>
			  <div class="input-group date">
				<input type="text" name="expiry_date" id="expiry_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <div class="form-group">
		      <label>*Sex:</label>
		      <div class="radio">
			      <label><input style="margin-top: 2px" type="radio" name="sex" value="Male" checked=""> Male&nbsp;&nbsp;</label>
			      <label><input style="margin-top: 2px" type="radio" name="sex" value="Female"> Female </label>
		      </div>
		  </div>
		  <div class="form-group">
		    <label>*Address:</label>
		    <textarea rows="4" class="form-control" placeholder="Enter address" name="address" id="address" maxlength="400" required=""></textarea>
		  </div>
		  <div style="text-align: right" id="address_characters"></div>
		  <div class="form-group">
		    <label>*Sector:</label>
		    <input type="text" class="form-control" placeholder="Enter sector" name="sector" id="sector" required="">
		  </div>
		  <div class="form-group">
		    <label>*City:</label>
		    <input type="text" class="form-control" placeholder="Enter city" name="city" id="city" required="">
		  </div>
		  <div class="form-group">
		    <label>Op.Security Amt:</label>
		    <input type="number" class="form-control" placeholder="Enter Op.security amount" name="opsec_amt" id="opsec_amt">
		  </div>
		  <div class="form-group">
		      <label>Op.Security Amt Date:</label>
			  <div class="input-group date">
				<input type="text" name="opsecamt_date" id="opsecamt_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
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