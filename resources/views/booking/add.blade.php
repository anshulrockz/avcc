@extends('layouts.website')
@section('content')
<script type='text/javascript'>
	function auto_date(){
		document.getElementById("from_date").value = document.getElementById("function_date").value;
		document.getElementById("to_date").value = document.getElementById("function_date").value;
	}
	function checkFacility(val){
		var selectedFacility = $(val).find('option:selected').text();
		if(selectedFacility == 'Guest Room'){
			$('#quantity').val('');
			$('.quantity_block').show();
		}
		else{
			$('#quantity').val('');
			$('.quantity_block').hide();
		}
	}
	function checkSponsor(){
		if($("#sponsor").prop('checked') == true){
		    $('#party_name').val('');
		    $('#phone').val('');
		    $('#mobile').val('');
		    $('#address').val('');
		}
		else{
			var member_name = $('#member_name').val();
			$('#party_name').val(member_name);
		}
	}
</script>
<script type='text/javascript'>
$(function(){
$(".search").click(function(){
	var membership_no = $('#membership_no').val();
	if(membership_no != ''){
		$.ajax({
			type: "GET",
			url: "{{url('/booking/ajax-member')}}",
			data:'membership_no='+membership_no,
			success: function(data){
				var obj = JSON.parse(data);
				if(obj[0].length >0){
					$('.alert.alert-danger').hide();
					var member_name = obj[0][0].name;
					var member_type = obj[0][0].member_type;
					var membertype_id = obj[0][0].membertype_id;
					var phone = obj[0][0].phone;
					var mobile = obj[0][0].mobile;
					var address = obj[0][0].address;
					$('#member_name').val(member_name);
					$('#member_type').val(member_type);
					$('#membertype_id').val(membertype_id);
					$('#phone').val(phone);
					$('#mobile').val(mobile);
					$('#address').val(address);
					if($("#sponsor").prop('checked') == true){
					    $('#party_name').val('');
					    $('#phone').val('');
					    $('#mobile').val('');
					    $('#address').val('');
					}
					else{
						$('#party_name').val(member_name);
					}
				}
				else{
					$("form").before('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Oops!</strong> Membership number not found!</div>');
					setTimeout(function(){ $('.alert.alert-danger').fadeOut(300)}, 5000);
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#member_name').val('');
					$('#member_type').val('');
					$('#membertype_id').val('');
					$('#phone').val('');
					$('#mobile').val('');
					$('#address').val('');
				}
			}
		});
	}
});

$('#from_time,#to_time').timepicker({ 'timeFormat': 'h:i A' });

var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
$('.input-group.date').datepicker({
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true,
    format: "dd-MM-yyyy"
//    startDate: today
});

});
</script>
<div class="pageheader">
		<div class="media">
		<div class="pageicon pull-left">
            <i style="padding: 10px 0 0 0;" class="fa fa-book"></i>
        </div>
        <div class="media-body">
    	<h4>Add Booking</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/booking') }}">Booking</a></li>
            <li>Add</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-9">
		@include('flashmessage')
		<form method="post" action="{{ url('booking/save') }}" id="valWizard" class="panel-wizard">
		{{ csrf_field() }}
            <ul class="nav nav-justified nav-wizard nav-disabled-click">
                <li><a href="#tab1-4" data-toggle="tab"><strong>Step 1:</strong> Booking Entry</a></li>
                <li><a href="#tab2-4" data-toggle="tab"><strong>Step 2:</strong> Add Facility</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab1-4">
					<div class="form-group">
					    <label>Booking ID:</label>
					    <input type="number" class="form-control" name="booking_id" id="booking_id" value="{{$booking_id+1}}" disabled="">
					</div>
					<div class="form-group">
					    <label>Booking Form No:</label>
					    <input type="number" class="form-control" placeholder="Enter booking number" name="booking_no" id="booking_no">
					</div>
					<div class="form-group">
					    <label>Booking Date:</label>
					    <div class="input-group date">
						  <input type="text" name="booking_date" id="booking_date" class="form-control" placeholder="Enter booking date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					    </div>
					</div>
				    <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
						      <label>*Membership No:</label>
							  <div class="input-group noerror">
								<input type="number" class="form-control" placeholder="Enter membership number" name="membership_no" id="membership_no" required=""><span class="input-group-addon search"><i class="fa fa-search"></i></span>
							  </div>
						    </div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <div style="margin-top: 32px">
                                    <input type="checkbox" name="sponsor" id="sponsor" value="1" onchange="checkSponsor();">
                                    <label for="checkboxDefault">Sponsored (Casual membership rates apply)</label>
                                </div>
							</div>
						</div>
					</div>
				    <div class="form-group">
					    <label>Member Name:</label>
					    <input type="text" class="form-control" id="member_name" disabled="">
					</div>
					<div class="form-group">
					    <label>Member Type:</label>
					    <input type="text" class="form-control" id="member_type" disabled="">
					    <input type="hidden" class="form-control" id="membertype_id">
					</div>
					<div class="form-group">
					    <label>Phone:</label>
					    <input type="number" class="form-control" placeholder="Enter phone" name="phone" id="phone">
					</div>
					<div class="form-group">
					    <label>Mobile:</label>
					    <input type="number" class="form-control" placeholder="Enter mobile" name="mobile" id="mobile">
					</div>
					<div class="form-group">
					  <label>Address:</label>
					  <textarea rows="4" class="form-control" placeholder="Enter address" name="address" id="address" maxlength="400"></textarea>
					</div>
					<div class="form-group">
					    <label>Bill Number:</label>
					    <input type="number" class="form-control" placeholder="Enter bill number" name="bill_no" id="bill_no">
					</div>
					<div class="form-group">
					    <label>Bill Date:</label>
					    <div class="input-group date">
						  <input type="text" name="bill_date" id="bill_date" class="form-control" placeholder="Enter bill date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					    </div>
					</div>
					<div class="form-group">
					    <label>*Party Name:</label>
					    <input type="text" class="form-control" placeholder="Enter party name" name="party_name" id="party_name" required="">
					</div>
					<div class="form-group">
					    <label>Party GSTIN:</label>
					    <input type="text" class="form-control" placeholder="Enter party GSTIN" name="party_gstin" id="party_gstin">
					</div>
					<div class="form-group">
					    <label>*Reverse Charges:</label>
					    <select class="form-control" name="reverse_charges" id="reverse_charges" required="">
					    	<option value="1">Yes</option>
					    	<option value="0" selected="">No</option>
					    </select>
					</div>
					<div class="form-group">
					    <label>*Function Date:</label>
					    <div class="input-group date noerror">
						  <input onchange="auto_date();" type="text" name="function_date" id="function_date" class="form-control" placeholder="Enter function date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					    </div>
					</div>
					<div class="form-group" style="display: inline-block; width: 49.6%">
					    <label>*Function Time:</label>
						<div class="input-group clockpicker noerror">
						  <input type="text" class="form-control" name="from_time" id="from_time" placeholder="Enter from time" required="">
						  <span class="input-group-addon">
						    <span class="glyphicon glyphicon-time"></span>
						  </span>
						</div>
					</div>
					<div class="form-group" style="display: inline-block; width:49.6%">
						<label>&nbsp;</label>
						<div class="input-group clockpicker noerror">
						  <input type="text" class="form-control" name="to_time" id="to_time" placeholder="Enter to time" required="">
						  <span class="input-group-addon">
						    <span class="glyphicon glyphicon-time"></span>
						  </span>
						</div>
					</div>
					<div class="form-group">
					    <label>Function Type:</label>
					    <input type="text" class="form-control" placeholder="Enter function type" name="function_type" id="function_type">
					</div>
					<div class="form-group">
					    <label>No of Persons:</label>
					    <input type="number" class="form-control" placeholder="Enter number of persons" name="noofpersons" id="noofpersons">
					</div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="tab2-4">
                    <table class="table table-bordered" id="bookingTable">
				      <tbody>
				      	<tr>
				      	  <td width="150px">
				      	  	<select class="form-control" name="facility" id="facility">
					      		<option value="">Select Facility</option>
					      		@foreach ($facility as $value)
					      		<option value="{{ $value->id }}">{{ $value->name }}</option>
					      		@endforeach
					        </select>
				      	  </td>
				      	  <td style="min-width: 140px;" class="noerror quantity_block">
				      	  	<input type="number" id="quantity" class="form-control" placeholder="Enter Quantity" max="8" min="1">
				      	  </td>
				      	  <td style="min-width: 120px">
				      	  	<select class="form-control" name="ac" id="ac">
					      		<option value="1">With AC</option>
					      		<option value="0">Without AC</option>
					        </select>
				      	  </td>
						  <td style="max-width: 200px" class="noerror">
							  <div class="input-group date">
								<input type="text" name="from_date" id="from_date" class="form-control" placeholder="Enter from date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							  </div>
						  </td>
						  <td style="max-width: 200px" class="noerror">
							  <div class="input-group date">
								<input type="text" name="to_date" id="to_date" class="form-control" placeholder="Enter to date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							  </div>
						  </td>
						  <td class="noerror"><a onclick="addFacility(document.getElementById('facility').value,document.getElementById('membertype_id').value,document.getElementById('from_date').value,document.getElementById('to_date').value);" class="add_button" href="javascript:void(0);" title="Add field"><img src="{{url('images/add-icon.png')}}"></a></td>
						</tr>
				      </tbody>
					</table>
					<div class="table-responsive" style="overflow-x: scroll">
						<table class="table table-bordered">
							<tr>
				                <th style="min-width: 100px">Facility</th>
				                <th style="min-width: 100px">Quantity</th>
				                <th style="min-width: 100px">No of Days</th>
				                <th style="min-width: 150px">From Date</th>
				                <th style="min-width: 150px">To Date</th>
				                <th style="min-width: 100px">Booking Rate</th>
				                <th style="min-width: 100px">Generator Charges</th>
				                <th style="min-width: 100px">AC Charges</th>
				                <th style="min-width: 100px">Safai &amp; General</th>
				                <th style="min-width: 100px">Security Charges</th>
				                <th style="min-width: 100px">Safai (Rebate)</th>
				                <th style="min-width: 100px">Tentage (Rebate)</th>
				                <th style="min-width: 100px">Catering (Rebate)</th>
				                <th style="min-width: 100px">Electricity (Rebate)</th>
				                <th style="min-width: 100px">CGST (%)</th>
				                <th style="min-width: 100px">CGST (Amt)</th>
				                <th style="min-width: 100px">SGST (%)</th>
				                <th style="min-width: 100px">SGST (Amt)</th>
				                <th style="min-width: 100px">Total Amount</th>
				                <th>Action</th>
				            </tr>
							<tbody class="field_wrapper">
								<tr class="bottom-area">
									<td colspan="18"><input class="form-control" type="text" name="misc" placeholder="Misc"></td>
									<td colspan="2" class="noerror"><input class="form-control" type="number" name="misc_amount" placeholder="Enter amount"></td>
								</tr>
								<tr>
									<td colspan="18"><input class="form-control" type="text" name="others" placeholder="Others"></td>
									<td colspan="2" class="noerror"><input class="form-control" type="number" name="others_amount" placeholder="Enter amount"></td>
								</tr>
							</tbody>
						</table>
					</div>
                </div><!-- tab-pane -->
            </div><!-- tab-content -->
            <ul class="list-unstyled wizard">
                <li class="pull-left previous"><button type="button" class="btn btn-default">Previous</button></li>
                <li class="pull-right next"><button type="button" class="btn btn-primary">Next</button></li>
                <li class="pull-right finish hide"><button id="submitButton" onclick="submitForm()" type="button" class="btn btn-primary">Finish</button></li>
            </ul>
        </form>
      </div>
	</div>
</div>
</div>
<script>
function submitForm(){
	document.getElementById("submitButton").disabled = true;
	document.getElementById("valWizard").submit();
}
var maxField = 21; //Input fields increment limitation
var addButton = $('.add_button'); //Add button selector
var wrapper = $('.field_wrapper'); //Input field wrapper
var x = 1; //Initial field counter is 1
$(wrapper).on('click', '.remove_button', function(e){
	e.preventDefault();
	$(this).closest("tr").remove();
	x--;
});

function in_array(array, id) {
    for(var i=0;i<array.length;i++) {
       if(array[i] == id)
        return true;
    }
    return false;
}

function addFacility(facility,memberType,fromDate,toDate){
	
	if($('#sponsor').is(':checked'))
	{
		memberType = '1';
	}
	
	var faclityStr = $("input[name='facility_id[]']").map(function(){return $(this).val();}).get();
	var facilityArr = JSON.parse("["+ faclityStr +"]");

//	var faciltyAlreadyAdded= in_array(facilityArr, facility);
//	if(faciltyAlreadyAdded){
//		$("#bookingTable").before('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Oops!</strong> This facility is already added!</div>');
//		setTimeout(function(){ $('.alert.alert-danger').fadeOut(300)}, 3000);
//		return false;
//	}
	
	function edate_format(edate){
		var myDate = new Date(edate);
		var d = myDate.getDate();
		var m =  myDate.getMonth();
		m += 1;  
		var y = myDate.getFullYear();
		var newdate=(y+ "-" + m + "-" + d);
		return newdate;
	}

	var fromDate1 = edate_format(fromDate);
	var toDate1 = edate_format(toDate);

	var firstDate = new Date(fromDate);
	var secondDate = new Date(toDate);
	var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(24*60*60*1000)));
	var noofDays = diffDays+1;
	var quantity = '1';
	if($('#quantity').val() != '')
	{
		quantity = $('#quantity').val();
	}
	
	if(facility!='' && from_date!='' && to_date!=''){
		$.ajax({
			type: "GET",
			url: "{{url('/addfacility/ajax')}}",
			data:'facility_id='+facility+'&membertype_id='+memberType+'&from_date='+fromDate+'&to_date='+toDate,
			success: function(data){
				var obj = JSON.parse(data);
				var servicetaxPercentage = 0;
				var vatPercentage = 0;
				var facility_name = obj[0][0].name;
				var facility_id = obj[0][0].id;
				var booking_rate = obj[0][0].booking_rate;
				var generator_charges = obj[0][0].generator_charges;
				var ac_charges = '0.00';
				if($('#ac').val() == '1')
				{
					ac_charges = obj[0][0].ac_charges;
				}
				var safai_general = obj[0][0].safai_general;
				var security_charges = obj[0][0].security_charges;
				var rebate_safai = obj[0][0].rebate_safai;
				var rebate_tentage = obj[0][0].rebate_tentage;
				var rebate_catering = obj[0][0].rebate_catering;
				var rebate_electricity = obj[0][0].rebate_electricity;
				
				$.each( obj[1], function( key, value ) {
				 if(value['name']=="CGST"){
				 	 servicetaxPercentage=value['percentage'];
				 }
				 if(value['name']=="SGST"){
				 	vatPercentage=value['percentage'];
				 }
				});
				
				// CGST Amount
				var servicetaxAmount = 0;
				servicetaxAmount = parseFloat(servicetaxPercentage)*(parseFloat(booking_rate)+parseFloat(generator_charges)+parseFloat(safai_general)+parseFloat(ac_charges))/100;
				// SGST Amount
				var vatAmount = 0;
				vatAmount = parseFloat(vatPercentage)*(parseFloat(booking_rate)+parseFloat(generator_charges)+parseFloat(safai_general)+parseFloat(ac_charges))/100;
				// Total Amount
				var totalAmount = 0;
				totalAmount = parseFloat(noofDays)*parseFloat(quantity)*(parseFloat(booking_rate)+parseFloat(generator_charges)+parseFloat(ac_charges)+parseFloat(safai_general));
				
				var fieldHTML = '<tr><td class="center"><span>'+facility_name+'</span><input type="hidden" name="facility_id[]" value="'+facility_id+'"></td><td class="center"><span>'+quantity+'</span><input type="hidden" name="quantity[]" value="'+quantity+'"></td><td class="center"><span>'+noofDays+'</span><input type="hidden" name="noofdays[]" value="'+noofDays+'"></td><td class="center"><span>'+fromDate+'</span><input type="hidden" name="from_date[]" value="'+fromDate1+'"></td><td class="center"><span>'+toDate+'</span><input type="hidden" name="to_date[]" value="'+toDate1+'"></td><td class="center"><span>'+booking_rate+'</span><input type="hidden" name="booking_rate[]" value="'+booking_rate+'"></td><td class="center"><span>'+generator_charges+'</span><input type="hidden" name="generator_charges[]" value="'+generator_charges+'"></td><td class="center"><span>'+ac_charges+'</span><input type="hidden" name="ac_charges[]" value="'+ac_charges+'"></td><td class="center"><span>'+safai_general+'</span><input type="hidden" name="safai_general[]" value="'+safai_general+'"></td><td class="center"><span>'+security_charges+'</span><input type="hidden" name="security_charges[]" value="'+security_charges+'"></td><td class="center"><span>'+rebate_safai+'</span><input type="hidden" name="rebate_safai[]" value="'+rebate_safai+'"></td><td class="center"><span>'+rebate_tentage+'</span><input type="hidden" name="rebate_tentage[]" value="'+rebate_tentage+'"></td><td class="center"><span>'+rebate_catering+'</span><input type="hidden" name="rebate_catering[]" value="'+rebate_catering+'"></td><td class="center"><span>'+rebate_electricity+'</span><input type="hidden" name="rebate_electricity[]" value="'+rebate_electricity+'"></td><td class="center"><span>'+servicetaxPercentage+'</span><input type="hidden" name="servicetaxPercentage[]" value="'+servicetaxPercentage+'"></td><td class="center"><span>'+servicetaxAmount+'</span><input type="hidden" name="servicetaxAmount[]" value="'+servicetaxAmount+'"></td><td class="center"><span>'+vatPercentage+'</span><input type="hidden" name="vatPercentage[]" value="'+vatPercentage+'"></td><td class="center"><span>'+vatAmount+'</span><input type="hidden" name="vatAmount[]" value="'+vatAmount+'"></td><td class="center"><span>'+totalAmount+'</span><input type="hidden" name="totalAmount[]" value="'+totalAmount+'"></td><td><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{url("images/remove-icon.png")}}"></a></td></tr>';
				if(x < maxField){
					x++;
					//$(wrapper).append(fieldHTML);
					$(fieldHTML ).insertBefore( ".bottom-area" );
				}
			}
		});
	}
	else{
		alert("Kindly fill all the details");
		if(document.getElementById("facility").value == ''){
			document.getElementById("facility").focus();
			return false;
		}
		if(document.getElementById("from_date").value == ''){
			document.getElementById("from_date").focus();
			return false;
		}
		if(document.getElementById("to_date").value == ''){
			document.getElementById("to_date").focus();
			return false;
		}
	}
}
jQuery(document).ready(function() {
//	$('.clockpicker').clockpicker();
    jQuery('#valWizard').bootstrapWizard({
        onTabShow: function(tab, navigation, index) {
            tab.prevAll().addClass('done');
            tab.nextAll().removeClass('done');
            tab.removeClass('done');
            $('.previous').hide();
            
            var $total = navigation.find('li').length;
            var $current = index + 1;
            
            if($current >= $total) {
                $('#valWizard').find('.wizard .next').addClass('hide');
                $('#valWizard').find('.wizard .finish').removeClass('hide');
            } else {
                $('#valWizard').find('.wizard .next').removeClass('hide');
                $('#valWizard').find('.wizard .finish').addClass('hide');
            }
        },
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onPrevious: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var $valid = jQuery('#valWizard').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
        }
    });
    // Wizard With Form Validation
    var $validator = jQuery("#valWizard").validate({
        highlight: function(element) {
            jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            jQuery(element).closest('.form-group').removeClass('has-error');
        }
    });
});
</script>
@endsection