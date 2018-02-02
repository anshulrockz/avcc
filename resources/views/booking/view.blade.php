@extends('layouts.website')
@section('content')
<script>
	function changeStatus(){
		$("#changeStatus").submit();
	}
	function calculateTotal(ele) {
		if($(ele).attr('name') == 'incl_sec'){
			if($(ele).is(':checked')){
				$('input[name=is_sec_checked]').val('1');
			}
			else{
				$('input[name=is_sec_checked]').val('0');			
			}
		}
		if($(ele).attr('name') == 'incl_tax'){
			if($(ele).is(':checked')){
				$('input[name=is_tax_checked]').val('1');
			}
			else{
				$('input[name=is_tax_checked]').val('0');
			}
		}
		var subTotal = $('.subTotal').text();
	    var serviceTax = $('.serviceTax').text();
	    var vat = $('.vat').text();
	    var tax = 0;
	    var security = 0;
	    if($('#incl_tax').prop("checked") == true){
			tax += parseFloat(serviceTax)+parseFloat(vat);
        }
        if($('#incl_sec').prop("checked") == true){
			security += $('.totalSecurity').text();
        }
        var total = parseFloat(subTotal)+parseFloat(security)+parseFloat(tax);
        $('.total').html('<b>'+total.toFixed(2)+'</b>');
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
		<div class="pageicon pull-left">
            <i style="padding: 10px 0 0 0;" class="fa fa-book"></i>
        </div>
		<div class="pull-right">
			@if($booking[0]->booking_status==1)
			<a href="javascript:" data-toggle="modal" data-target="#paymentModal" class="btn btn-primary"><i class="fa fa-edit"></i> Create Receipt</a>
			@endif
			<div class="modal fade paymentModal" id="paymentModal" tabindex="-1" role="dialog">
		            <div class="modal-dialog">
		              <div class="modal-content">
		                  <div class="modal-header">
		                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
		                      <h4 class="modal-title">Select Payment Mode</h4>
		                  </div>
		                  <form class="form-vertical" method="post" action="{{ url('booking/changestatus/'.$booking[0]->id) }}">
		                  	{{ csrf_field() }}
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
							  <input type="hidden" name="is_tax_checked" value="">
							  <input type="hidden" name="is_sec_checked" value="">
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
								@if(count($receipt_status)>0)
								<div><b>Note:</b>
										@foreach($receipt_status as $receipt_status)
										{{ $receipt_status->id }}
										@endforeach
										- Receipt will be auto cancelled with Booking ID: {{$booking[0]->id}}</div>
								@endif
			                </div>
			            	<div class="modal-footer">
						    	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="submit" class="btn btn-primary">Submit</button>
						    </div>
					      </form>
		              </div>
		            </div>
		        </div>
		</div>
        <div class="media-body">
    	<h4>View Booking</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/booking') }}">Booking</a></li>
            <li>View</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
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
		  <div class="table-responsive" style="overflow-x: scroll">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="17">Booking Details</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
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
	              <?php if(count($booking_facility)>0){?>
	              @foreach ($booking_facility as $value)
	              <tr>
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
	              <?php if($booking[0]->misc != ''){ ?>
	              <tr>
	                <td class="left-align">{{ $booking[0]->misc }}</td>
	                <td colspan="17"></td>
	                <td class="left-align">{{ $booking[0]->misc_amount }}</td>
	              </tr>
	              <?php }?>
	              <?php if($booking[0]->others != ''){ ?>
		              <tr>
		                <td class="left-align">{{ $booking[0]->others }}</td>
		                <td colspan="13"></td>
		                <td class="left-align">{{ $global_st }}</td>
		                <td class="left-align">{{ in_decimal($booking[0]->others_amount*$global_st/100) }}</td>
		                <td class="left-align">{{ $global_vat }}</td>
		                <td class="left-align">{{ in_decimal($booking[0]->others_amount*$global_vat/100) }}</td>
		                <td class="left-align">{{ $booking[0]->others_amount }}</td>
		              </tr>
		          <?php }?>
	              <?php } else{?>
		              @if($booking[0]->misc_amount > 0)
		              <tr>
		                <td class="left-align">{{ $booking[0]->misc }}</td>
		                <td colspan="17"></td>
		                <td class="left-align">{{ $booking[0]->misc_amount }}</td>
		              </tr>
		              @endif
		              <?php if($booking[0]->others_amount > 0){ ?>
			              <tr>
			                <td class="left-align">{{ $booking[0]->others }}</td>
			                <td colspan="13"></td>
			                <td class="left-align">{{ in_decimal($global_st) }}</td>
			                <td class="left-align">{{ in_decimal($booking[0]->others_amount*$global_st/100) }}</td>
			                <td class="left-align">{{ in_decimal($global_vat) }}</td>
			                <td class="left-align">{{ in_decimal($booking[0]->others_amount*$global_vat/100) }}</td>
			                <td class="left-align">{{ $booking[0]->others_amount }}</td>
			              </tr>
			          <?php }?>
	              <?php }?>
	              <?php if($is_receiptcreated == 0){ ?>
					  <tr>
						<td colspan="18" class="right-align">Sub-Total:</td>
						<td class="left-align subTotal"><b>{{number_format((float)$sub_total+$booking[0]->misc_amount+$booking[0]->others_amount, 2, '.', '')}}</b></td>
		              </tr>
		              <tr>
						<td style="border-top: none" colspan="18" class="right-align">Security:</td>
						<td style="border-top: none" class="left-align totalSecurity"><b>{{number_format((float)$security_charges, 2, '.', '')}}</b></td>
		              </tr>
		              <tr class="st-row">
		                <td style="border-top: none" colspan="18" class="right-align">CGST:</td>
		                <td style="border-top: none" class="left-align serviceTax"><b>{{number_format((float)$servicetax_total+$booking[0]->others_amount*$global_st/100, 2, '.', '')}}</b></td>
		              </tr>
		              <tr class="vat-row">
		                <td style="border-top: none" colspan="18" class="right-align">SGST:</td>
		                <td style="border-top: none" class="left-align vat"><b>{{number_format((float)$vat_total+$booking[0]->others_amount*$global_vat/100, 2, '.', '')}}</b></td>
		              </tr>
		              <tr>
		              	<td style="border-top: none" colspan="18" class="right-align">
		                <form id="changeStatus" method="post" action="">
		                {{ csrf_field() }}
		                <input onchange="calculateTotal(this);" type="checkbox" name="incl_sec" id="incl_sec" value="1" /> (With Security)
		                <input type="checkbox" name="incl_tax" id="incl_tax" checked="" value="1" disabled="" /> (With all taxes) 
		                &nbsp;&nbsp; Total:
		                </form>
		                </td>
	                	<td style="border-top: none" class="left-align total"><b>{{number_format((float)$sub_total+$booking[0]->misc_amount+$booking[0]->others_amount+$servicetax_total+$vat_total+$booking[0]->others_amount*$global_st/100+$booking[0]->others_amount*$global_vat/100, 2, '.', '')}}</b></td>
		              </tr>
				  <?php }else{?>
				  	  <tr>
						<td colspan="18" class="right-align">Sub-Total:</td>
						<td class="left-align subTotal"><b>{{number_format((float)$sub_total+$booking[0]->misc_amount+$booking[0]->others_amount, 2, '.', '')}}</b></td>
		              </tr>
		              @if($booking[0]->with_security == '1')
		              <tr class="st-row">
		                <td style="border-top: none" colspan="18" class="right-align">Security:</td>
		                <td style="border-top: none" class="left-align serviceTax"><b>{{number_format((float)$security_charges, 2, '.', '')}}</b></td>
		              </tr>
			          @endif
		              @if($booking[0]->with_tax == '1')
		              <tr class="st-row">
		                <td style="border-top: none" colspan="18" class="right-align">CGST:</td>
		                <td style="border-top: none" class="left-align serviceTax"><b>{{number_format((float)$servicetax_total+$booking[0]->others_amount*$global_st/100, 2, '.', '')}}</b></td>
		              </tr>
		              <tr class="vat-row">
		                <td style="border-top: none" colspan="18" class="right-align">SGST:</td>
		                <td style="border-top: none" class="left-align vat"><b>{{number_format((float)$vat_total+$booking[0]->others_amount*$global_vat/100, 2, '.', '')}}</b></td>
		              </tr>
			          @endif
			          <tr>
						<td style="border-top: none" colspan="18" class="right-align">Total:</td>
						<?php
						$tax = 0;
						$others_tax = 0;
						$security = 0;
						if($booking[0]->with_tax == '1'){
							$others_tax = $booking[0]->others_amount*$global_st/100+$booking[0]->others_amount*$global_vat/100;
							$tax = $servicetax_total+$vat_total;
						}
						if($booking[0]->with_security == '1'){
							$security = $security_charges;
						}
						$total = $sub_total+$booking[0]->misc_amount+$booking[0]->others_amount+$tax+$others_tax+$security;
						?>
						<td style="border-top: none" class="left-align subTotal"><b>{{round($total)}}</b></td>
		              </tr>
				  <?php }?>
	            </tbody>
	          </table>
          </div>
      	</div>
	</div>
</div>
</div>
@endsection