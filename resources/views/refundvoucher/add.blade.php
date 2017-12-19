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
function disableBookingEntry(){
	if($("#booking_no").val().length > 0){
		$('#party_name').prop("disabled","true");
		$('#phone').prop("disabled","true");
		$('#mobile').prop("disabled","true");
		$('#address').prop("disabled","true");
		$('#function_date').prop("disabled","true");
		$('#membership_no').prop("disabled","true");
	}
	else{
		$("#party_name").removeAttr("disabled");
		$("#phone").removeAttr("disabled");
		$("#mobile").removeAttr("disabled");
		$("#address").removeAttr("disabled");
		$("#function_date").removeAttr("disabled");
		$("#membership_no").removeAttr("disabled");
	}
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
$(".search").click(function(){
	var booking_no = $('#booking_no').val();
	var refund_type = $('#refund_type').val();
	if(booking_no != ''){
		$.ajax({
			type: "GET",
			url: "{{url('/refund-voucher/ajax')}}",
			data:'booking_no='+booking_no+'&refund_type='+refund_type,
			success: function(data){
				var obj = JSON.parse(data);
				if(obj[0].length >0){
					var party_name = obj[0][0].party_name;
					var phone = obj[0][0].phone;
					var membership_no = obj[0][0].membership_no;
					var address = obj[0][0].address;
					var function_date = dfy_format(obj[0][0].function_date);
					var booking_date = dfy_format(obj[0][0].booking_date);
					var membership_no = obj[0][0].membership_no;
					var with_tax = obj[0][0].with_tax;
					var with_security = obj[0][0].with_security;
					
					var sub_total = obj[0][0].sub_total;
					var service_tax = obj[0][0].service_tax;
					var vat = obj[0][0].vat;
					var security_total = obj[0][0].security_total;
					var cancel_amount = obj[0][0].cancel_amount;
					
					var tax = 0;
					var security = 0;
					var refunded_amount = 0;
					var total_amount = 0;
					
					if(with_tax == '1'){
						tax = parseFloat(service_tax)+parseFloat(vat);
					}
					if(with_security == '1'){
						security = security_total;
					}
					if(refund_type == '1'){
						refunded_amount = parseFloat(tax)+parseFloat(sub_total)+parseFloat(security) - parseFloat(cancel_amount);
						total_amount = parseFloat(tax)+parseFloat(sub_total)+parseFloat(security);
					}
					if(refund_type == '2'){
						refunded_amount = parseFloat(security);
						cancel_amount = 0;
						total_amount = parseFloat(security);
					}
					$('#deduction').val(cancel_amount);
					$('#refunded_amount').val(parseFloat(refunded_amount).toFixed(2));
					$('#party_name').val(party_name);
					$('#party_name').prop("disabled","true");
					$('#phone').val(phone);
					$('#phone').prop("disabled","true");
					$('#membership_no').val(membership_no);
					$('#membership_no').prop("disabled","true");
					$('#address').val(address);
					$('#address').prop("disabled","true");
					$('#function_date').val(function_date);
					$('#function_date').prop("disabled","true");
					$('#booking_date').val(booking_date);
					$('#booking_date').prop("disabled","true");
					$('#total_amount').val(parseFloat(total_amount).toFixed(2));
				}
				else{
					$("form").before('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Oops!</strong> You have entered an invalid receipt number!</div>');
					setTimeout(function(){ $('.alert.alert-danger').fadeOut(300)}, 4000);
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#booking_date').val('');
					$('#party_name').val('');
					$('#membership_no').val('');
					$('#function_date').val('');
					$('#total_amount').val('');
					$('#deduction').val('');
					$('#refunded_amount').val('');
				}
			}
		});
	}
});
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
					  <div class="input-group">
						<input type="number" class="form-control" placeholder="Enter receipt number" name="booking_no" id="booking_no" onkeyup="disableBookingEntry();"><span class="input-group-addon search"><i class="fa fa-search"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Booking Date:</label>
					    <input type="text" class="form-control" name="booking_date" id="booking_date" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Party Name:</label>
					    <input type="text" class="form-control" name="party_name" id="party_name" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Membership No:</label>
					    <input type="text" class="form-control" name="membership_no" id="membership_no" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Function Date:</label>
						<input type="text" class="form-control" name="function_date" id="function_date" disabled="">
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Total Amount:</label>
					    <input type="text" class="form-control" name="total_amount" id="total_amount" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Deduction:</label>
					    <input type="text" class="form-control" name="deduction" id="deduction" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Refunded Amount:</label>
					    <input type="text" class="form-control" name="refunded_amount" id="refunded_amount" disabled="">
					</div>
				</div>
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
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group" id="chequeNo_section" style="display: none">
					    <label>Cheque/DD No/Direct Txn No:</label>
					    <input type="text" class="form-control" placeholder="Enter Cheque/DD No" name="cheque_no" id="cheque_no">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" id="chequeDate_section" style="display: none">
				      <label>Dated:</label>
					  <div class="input-group date">
						<input type="text" name="cheque_date" id="cheque_date" class="form-control" placeholder="Enter Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
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