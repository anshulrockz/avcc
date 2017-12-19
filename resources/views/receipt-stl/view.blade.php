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
		@if($booking[0]->with_tax == '0')
		<div class="pull-right">
			<a href="javascript:" data-toggle="modal" data-target="#paymentModal" class="btn btn-primary"><i class="fa fa-money"></i> Receive Payment</a>
			<div class="modal fade paymentModal" id="paymentModal" tabindex="-1" role="dialog">
		            <div class="modal-dialog">
		              <div class="modal-content">
		                  <div class="modal-header">
		                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
		                      <h4 class="modal-title">Select Payment Mode</h4>
		                  </div>
		                  <form class="form-vertical" method="post" action="{{ url('receipt-stl/save/'.$booking[0]->id) }}">
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
		@endif
        <div class="media-body">
    	<h4>Tax Liability</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/receipt-stl') }}">Tax Liability</a></li>
            <li>{{$booking[0]->id}}</li>
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
	            <tbody>
	              <tr>
	                <td style="min-width: 100px;border-top: none" class="left-align"><b>S.No</b></td>
	                <td style="min-width: 100px;border-top: none" class="left-align"><b>Particular</b></td>
	                <td style="min-width: 100px;border-top: none" class="left-align"><b>Amount</b></td>
	              </tr>
	              <tr>
	                <td class="left-align">1</td>
	                <td class="left-align">CGST</td>
	                <td class="left-align">{{$booking[0]->service_tax+$booking[0]->others_amount*$global_st/100}}</td>
	              </tr>
	              <tr>
	                <td class="left-align">2</td>
	                <td class="left-align">SGST</td>
	                <td class="left-align">{{$booking[0]->vat+$booking[0]->others_amount*$global_vat/100}}</td>
	              </tr>
	              <tr>
	                <td colspan="2" class="right-align">Total:</td>
	                <td class="left-align total"><b>{{number_format((float)$booking[0]->service_tax+$booking[0]->vat+$booking[0]->others_amount*$global_st/100+$booking[0]->others_amount*$global_vat/100, 2, '.', '')}}</b></td>
	              </tr>
	            </tbody>
	          </table>
          </div>
      	</div>
	</div>
</div>
</div>
@endsection