@extends('layouts.website')
@section('content')
<script>
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
		<div class="pageicon pull-left">
            <i style="padding: 10px 0 0 0;" class="fa fa-scissors"></i>
        </div>
        <div class="media-body">
    	<h4>Partial Cancellation</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/refund-voucher') }}">Refund Voucher</a></li>
            <li>Partial Cancellation</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">  
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" method="get" action="">
				<div class="form-group" style="margin-right: 0">
					<input type="number" name="token" class="form-control" placeholder="Enter receipt number" required="">
				</div>
				<button type="submit" class="btn btn-info">Find</button>
			</form>
		</div>
	</div>   
    <div class="row" style="margin-top: 20px">
	    <div class="col-md-12">
	    	@include('flashmessage')
	    	@if(count($booking)>0 && !empty($booking_no))
	    	<div class="table-responsive">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="4">Booking Entry</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
	                <td style="padding-top: 15px" class="facility-td"><b>Booking No:</b></td>
	                <td style="padding-top: 15px" class="facility-td"><?php echo $booking[0]->booking_no; ?></td>
	                <td style="padding-top: 15px" class="facility-td"><b>Booking Date:</b></td>
	                <td style="padding-top: 15px" class="facility-td"><?php echo date_dfy($booking[0]->booking_date); ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Party Name:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->party_name; ?></td>
	                <td class="facility-td"><b>Function Date:</b></td>
	                <td class="facility-td"><?php echo date_dfy($booking[0]->function_date); ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Function Time:</b></td>
	                <td class="facility-td"><?php echo am_pm($booking[0]->from_time).' - '.am_pm($booking[0]->to_time); ?></td>
	                <td class="facility-td"><b>Function Type:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->function_type; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Bill No:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->bill_no; ?></td>
	                <td class="facility-td"><b>Bill Date:</b></td>
	                <td class="facility-td"><?php echo date_dfy($booking[0]->bill_date); ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Member:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->member_name; ?></td>
	                <td class="facility-td"><b>Member Type:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->member_type; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Phone:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->phone; ?></td>
	                <td class="facility-td"><b>Mobile:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->mobile; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Address:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->address; ?></td>
	                <td class="facility-td"><b>No of Persons:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->noofpersons; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Booking Status:</b></td>
	                <?php
	                if($booking[0]->booking_status == '0'){
						$booking_status = "Pending";
					}
	                elseif($booking[0]->booking_status == '1'){
						$booking_status = "Booked";
					}
					else{
						$booking_status = "Cancelled";
					}
	                ?>
	                <td class="facility-td">{{$booking_status}}</td>
	              </tr>
	              <?php if($booking_status == 'Cancelled'){ ?>
	              <tr>
	                <td class="facility-td"><b>Cancel Date:</b></td>
	                <td class="facility-td"><?php echo date_dfy($booking[0]->cancel_date); ?></td>
	                <td class="facility-td"><b>Cancel (%):</b></td>
	                <td class="facility-td"><?php echo $booking[0]->cancel_percentage; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Cancel Amount:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->cancel_amount; ?></td>
	              </tr>
				  <?php }?>
	            </tbody>
	          </table>
            </div>
			<form method="post" action="{{ url('refund-voucher/partialupdate/'.$booking[0]->id) }}">
			{{ csrf_field() }}
			<div class="table-responsive" style="overflow-x: scroll">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="17">Facility Details</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
	                <td style="min-width: 100px" class="left-align"><b>Select</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Facility</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Quantity</b></td>
	                <td style="min-width: 100px" class="left-align"><b>No of Days</b></td>
	                <td style="min-width: 150px" class="left-align"><b>From Date</b></td>
	                <td style="min-width: 150px" class="left-align"><b>To Date</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Booking Rate</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Safai &amp; General</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Generator</b></td>
	                <td style="min-width: 100px" class="left-align"><b>AC</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Security</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Safai (Rebate)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Tentage (Rebate)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Catering (Rebate)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Electricity (Rebate)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>CGST (%)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>CGST (Amt)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>SGST (%)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>SGST (Amt)</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Total Amount</b></td>
	              </tr>
	              @foreach ($bookingfacility as $value)
	              <tr>
	                <td class="left-align">
	                	<input type="checkbox" name="facility_checked[]" value="{{ $value->id }}"/>
	                	<!--<input type="hidden" name="facility_checked[]" value=""/>-->
	                	<input type="hidden" name="facility_hidden[]" value="{{ $value->id }}"/>
	                </td>
	                <td class="left-align">{{ $value->facility_name }}</td>
	                <td class="left-align">{{ $value->quantity }}</td>
	                <td class="left-align">{{ slash_decimal($value->noofdays) }}</td>
	                <td class="left-align">{{ date_dfy($value->from_date) }}</td>
	                <td class="left-align">{{ date_dfy($value->to_date) }}</td>
	                <td class="left-align">{{ $value->booking_rate }}</td>
	                <td class="left-align">{{ $value->safai_general }}</td>
	                <td class="left-align">{{ $value->generator_charges }}</td>
	                <td class="left-align">{{ $value->ac_charges }}</td>
	                <td class="left-align">{{ $value->security_charges }}</td>
	                <td class="left-align">{{ $value->rebate_safai }}</td>
	                <td class="left-align">{{ $value->rebate_tentage }}</td>
	                <td class="left-align">{{ $value->rebate_catering }}</td>
	                <td class="left-align">{{ $value->rebate_electricity }}</td>
	                <td class="left-align">{{ $value->servicetax_percentage }}</td>
	                <td class="left-align">{{ $value->servicetax_amount }}</td>
	                <td class="left-align">{{ $value->vat_percentage }}</td>
	                <td class="left-align">{{ $value->vat_amount }}</td>
	                <td class="left-align">{{ $value->total_amount }}</td>
	              </tr>
	              @endforeach
	            </tbody>
	          </table>
          </div>
          	<!--<button style="margin-top: 20px" type="submit" class="btn btn-primary">Remove all checked items</button>-->
          	<a style="margin-top: 20px" href="javascript:" data-toggle="modal" data-target="#paymentModal" class="btn btn-primary"><i class="fa fa-trash-o"></i> Remove all checked items</a>
          	<div class="modal fade paymentModal" id="paymentModal" tabindex="-1" role="dialog">
	            <div class="modal-dialog">
	              <div class="modal-content">
	                  <div class="modal-header">
	                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
	                      <h4 class="modal-title">Select Payment Mode</h4>
	                  </div>
	                  <div class="modal-body">
	                  	  <div class="form-group">
						    <label>Payment Mode:</label>
						    <select class="form-control" name="payment_mode" id="payment_mode" required="" onchange="paymentMode(this.value);">
						    	<option value="Cash">Cash</option>
						    	<option value="Cheque">Cheque</option>
						    	<option value="DD">DD</option>
						    	<option value="Direct Transfer">Direct Transfer</option>
						    </select>
						  </div>
	                  	  <div class="form-group" id="chequeNo_section" style="display: none">
							  <label>Cheque/DD No/Direct Txn No:</label>
							  <input type="text" class="form-control" placeholder="Enter Cheque/DD No" name="cheque_no" id="cheque_no">
						  </div>
						  <div class="form-group" id="chequeDate_section" style="display: none">
						      <label>Dated:</label>
							  <div class="input-group date">
								<input type="text" name="cheque_date" id="cheque_date" class="form-control" placeholder="Enter Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							  </div>
						  </div>
						  <div class="form-group" id="chequeDrawn_section" style="display: none">
						      <label>Drawn On:</label>
						      <input type="text" class="form-control" placeholder="Enter Drawn on" name="cheque_drawn" id="cheque_drawn">
						  </div>
						  <input type="hidden" name="receipt_id" value="{{$_GET['token']}}"/>
	                  </div>
	                  <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
	              </div>
	            </div>
	        </div>
          	</form>
			@elseif(isset($_GET['booking_no']))
			<div>No Results Found!</div>
			@endif
		</div>
	</div>
</div>
</div>
@endsection