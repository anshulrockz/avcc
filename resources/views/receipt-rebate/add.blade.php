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
$(".search").click(function(){
	var receipt_no = $('#receipt_no').val();
	if(receipt_no != ''){
		$.ajax({
			type: "GET",
			url: "{{url('/receiptrebate/ajax')}}",
			data:'receipt_no='+receipt_no,
			success: function(data){
				var obj = JSON.parse(data);
				var receiptObj = obj.receipt;
				var rebateObj = obj.rebate;
				if(receiptObj != ''){
					var party_name = receiptObj.party_name;
					var phone = receiptObj.phone;
					var mobile = receiptObj.mobile;
					var address = receiptObj.address;
					var function_date = dfy_format(receiptObj.function_date);
					var membership_no = receiptObj.membership_no;
					var est_catering = receiptObj.est_catering;
					var est_cof = receiptObj.est_cof;
					var time_period = receiptObj.time_period;
					var reverse_charges = receiptObj.reverse_charges;
					var party_gstin = receiptObj.party_gstin;
					
					var safai = rebateObj.safai;
					var tentage = rebateObj.tentage;
					var catering = rebateObj.catering;

					if(time_period=='1'){
						electricity = rebateObj.electricity;
					}
					else{
						electricity = 0;
					}
					
					$('#party_name').val(party_name);
					$('#phone').val(phone);
					$('#mobile').val(mobile);
					$('#address').val(address);
					$('#function_date').val(function_date);
					$('#function_date').next().css('pointer-events','none');
					$('#membership_no').val(membership_no);
					$('#safai').val(Math.round(safai));
					$('#tentage').val(Math.round(tentage));
					$('#catering').val(est_catering*catering/100);
					$('#food').val(est_cof*catering/100);
					$('#electricity').val(Math.round(electricity));
					$('#party_gstin').val(party_gstin);
					$('#reverse_charges option[value="'+reverse_charges+'"]').prop('selected', true);
				}
				else{
					$("form").before('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Oops!</strong> Receipt number not found!</div>');
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
            <li><a href="{{ url('/receipt') }}">Receipt</a></li>
            <li>Rebate</li>
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
		<form method="post" action="{{ url('receipt-rebate/save') }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>*Receipt No:</label>
					  <div class="input-group">
						<input type="number" class="form-control" placeholder="Enter receipt number" name="receipt_no" id="receipt_no" required=""><span class="input-group-addon search"><i class="fa fa-search"></i></span>
					  </div>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Membership No:</label>
				      <input type="number" class="form-control" placeholder="Enter Membership No" name="membership_no" id="membership_no" disabled="">
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Party Name:</label>
					    <input type="text" class="form-control" placeholder="Enter Party Name" name="party_name" id="party_name" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Party GSTIN:</label>
					    <input type="text" class="form-control" placeholder="Enter Party GSTIN" name="party_gstin" id="party_gstin" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Reverse Charges:</label>
					    <select class="form-control" name="reverse_charges" id="reverse_charges" disabled="">
					    	<option value="1">Yes</option>
					    	<option value="0" selected="">No</option>
					    </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Phone:</label>
					    <input type="number" class="form-control" placeholder="Enter Phone" name="phone" id="phone" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Mobile:</label>
					    <input type="number" class="form-control" placeholder="Enter Mobile" name="mobile" id="mobile" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Address:</label>
					    <input type="text" class="form-control" placeholder="Enter Address" name="address" id="address" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Function Date:</label>
					  <div class="form-group">
						<input type="text" name="function_date" id="function_date" class="form-control" placeholder="Enter Function Date" disabled="">
					  </div>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Payment Mode:</label>
					    <select class="form-control" name="payment_mode" id="payment_mode" required="" onchange="paymentMode(this.value);" required="">
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
					    <input type="text" class="form-control" placeholder="Enter Drawn On" name="cheque_drawn" id="cheque_drawn">
					</div>
				</div>
			</div>
			<h5 style="text-decoration: underline;font-weight: bold;margin-bottom: 20px;"><span>Rebate</span></h5>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Safai:</label>
					    <input type="number" class="form-control" placeholder="Enter Amount" name="safai" id="safai">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Tentage:</label>
					    <input type="number" class="form-control" placeholder="Enter Amount" name="tentage" id="tentage">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Catering:</label>
					    <input type="number" class="form-control" placeholder="Enter Amount" name="catering" id="catering">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Food:</label>
					    <input type="number" class="form-control" placeholder="Enter Amount" name="food" id="food">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Electricity:</label>
					    <input type="number" class="form-control" placeholder="Enter Amount" name="electricity" id="electricity">
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