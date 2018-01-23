@extends('layouts.website')
@section('content')
<script type='text/javascript'>
function dfy_format(edate){
  var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
  var date = new Date(edate);
  var d = ("0" + date.getDate()).slice(-2);
  var f = monthNames[date.getMonth()];
  var y = date.getFullYear();
  return d+'-'+f+'-'+y;
}
function paymentMode(mode){
	if(mode == 'Cheque' || mode == 'DD'){
		$('#chequeNo_section').show();
		$('#chequeDate_section').show();
		$('#chequeDrawn_section').show();
	}
	else if(mode == 'Direct Transfer'){
		$('#chequeNo_section').show();
		$('#chequeDate_section').show();
		$('#chequeDrawn_section').hide();
	}
	else{
		$('#chequeNo_section').hide();
		$('#chequeDate_section').hide();
		$('#chequeDrawn_section').hide();
	}
}
$(function(){
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
$('.input-group.date').datepicker({
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true,
    format: "dd-MM-yyyy",
    //startDate: today
});  
});
</script>
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Create Refund Voucher</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/refund-voucher') }}">Refund Voucher</a></li>
            <li>Create</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-9">
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
		<form method="post" action="{{ url('refund-voucher/save') }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Voucher ID:</label>
					    <input type="number" class="form-control" name="voucher_id" id="voucher_id" value="{{$voucher_id+1}}" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Voucher Date:</label>
					  <div class="input-group date">
						<input type="text" name="voucher_date" id="voucher_date" class="form-control" placeholder="Enter Voucher Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Refund Type:</label>
					    <select class="form-control" name="refund_type" id="refund_type" required="">
					    	<option value="1">Full Cancellation</option>
					    	<option value="2">Security Charges</option>
					    </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Receipt No:</label>
						<input type="number" class="form-control" placeholder="Enter receipt number" name="receipt_no" id="receipt_no">
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Payment Mode:</label>
					    <select class="form-control" name="payment_mode" id="payment_mode" required="" onchange="paymentMode(this.value);">
					    	<option value="Cash">Cash</option>
					    	<option value="Cheque">Cheque</option>
					    	<option value="DD">DD</option>
					    	<option value="Direct Transfer">Direct Transfer</option>
					    </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" id="chequeNo_section" style="display: none">
					    <label>Cheque/DD No/Direct Txn No:</label>
					    <input type="text" class="form-control" placeholder="Enter Cheque/DD No" name="cheque_no" id="cheque_no">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group" id="chequeDate_section" style="display: none">
				      <label>Dated:</label>
					  <div class="input-group date">
						<input type="text" name="cheque_date" id="cheque_date" class="form-control" placeholder="Enter Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" id="chequeDrawn_section" style="display: none">
					    <label>Drawn On:</label>
					    <input type="text" class="form-control" placeholder="Enter Drawn on" name="cheque_drawn" id="cheque_drawn">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
        </form>
      </div>
	</div>
</div>
</div>
@endsection