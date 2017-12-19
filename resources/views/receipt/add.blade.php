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
		$('#member_id').prop("disabled","true");
	}
	else{
		$("#party_name").removeAttr("disabled");
		$("#phone").removeAttr("disabled");
		$("#mobile").removeAttr("disabled");
		$("#address").removeAttr("disabled");
		$("#function_date").removeAttr("disabled");
		$("#member_id").removeAttr("disabled");
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
	if(booking_no != ''){
		$.ajax({
			type: "GET",
			url: "{{url('/receipt/ajax')}}",
			data:'booking_no='+booking_no,
			success: function(data){
				var obj = JSON.parse(data);
				if(obj[0].length >0){
					var party_name = obj[0][0].party_name;
					var phone = obj[0][0].phone;
					var mobile = obj[0][0].mobile;
					var address = obj[0][0].address;
					var function_date = dfy_format(obj[0][0].function_date);
					var member_id = obj[0][0].member_id;
					$('#party_name').val(party_name);
					$('#party_name').prop("disabled","true");
					$('#phone').val(phone);
					$('#phone').prop("disabled","true");
					$('#mobile').val(mobile);
					$('#mobile').prop("disabled","true");
					$('#address').val(address);
					$('#address').prop("disabled","true");
					$('#function_date').val(function_date);
					$('#function_date').prop("disabled","true");
					$('#function_date').next().css('pointer-events','none');
					$('#member_id option[value="'+member_id+'"]').prop('selected', true);
					$('#member_id').prop("disabled","true");
				}
				else{
					$("form").before('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Oops!</strong> Booking number not found!</div>');
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
    	<h4>Create receipt</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Receipt</li>
            <li>Tentage &amp; Catering</li>
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
		<form method="post" action="{{ url('receipt/save') }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Booking Form No:</label>
					  <div class="input-group">
						<input type="number" class="form-control" placeholder="Enter booking number" name="booking_no" id="booking_no" onkeyup="disableBookingEntry();"><span class="input-group-addon search"><i class="fa fa-search"></i></span>
					  </div>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Membership No:</label>
				      <input type="number" class="form-control" placeholder="Enter membership no" name="membership_no" id="membership_no">
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Party Name:</label>
					    <input type="text" class="form-control" placeholder="Enter party name" name="party_name" id="party_name" required="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Phone:</label>
					    <input type="number" class="form-control" placeholder="Enter phone" name="phone" id="phone">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Mobile:</label>
					    <input type="number" class="form-control" placeholder="Enter mobile" name="mobile" id="mobile">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Address:</label>
					    <input type="text" class="form-control" placeholder="Enter address" name="address" id="address">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Function Date:</label>
					  <div class="input-group date">
						<input type="text" name="function_date" id="function_date" class="form-control" placeholder="Enter Function Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
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
			<h5 style="text-decoration: underline;font-weight: bold;margin-bottom: 20px;"><span>Tentage &amp; Catering</span></h5>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Estimated Cost of the food:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="est_cof" id="est_cof">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>SGST to be charged by the supplier:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="vat_supplier" id="vat_supplier">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Estimated amount for catering service:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="est_catering" id="est_catering">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>SGST to be charged by the caterer:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="vat_caterer" id="vat_caterer">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>CGST to be charged by the caterer:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="st_caterer" id="st_caterer">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Estimated cost of Tentage:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="est_tentage" id="est_tentage">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>SGST to be charged by Tent Supplier:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="vat_tent" id="vat_tent">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>CGST to be charged by Tent Supplier:</label>
					    <input type="number" class="form-control" placeholder="Enter amount" name="st_tent" id="st_tent">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					      <label>*Contractor:</label>
					      <select class="form-control" name="contractor" id="contractor" required="">
					      		<option value="">Select</option>
					      		@foreach ($contractor as $value)
					      		<option value="{{ $value->id }}">{{ $value->name }}</option>
					      		@endforeach
					      </select>
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