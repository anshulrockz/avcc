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
		var wrapper = $('.field_wrapper'); //Input field wrapper
		var x = 1; //Initial field counter is 1
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).closest("tr").remove();
			x--;
		});
		
		$('.field_wrapper').on('click', '.quantityDecrement', function(e){
			e.preventDefault();
			var value = $(this).closest('tr').find('input.quantityVal').val();
			value = isNaN(value) ? 0 : value;
			if(value>1){
		        value--;
				$(this).closest('tr').find('input.quantityVal').val(value);
		    }
		});
		
		$('.field_wrapper').on('click', '.daysDecrement', function(e){
			e.preventDefault();
			var value = $(this).closest('tr').find('input.daysVal').val();
			value = isNaN(value) ? 0 : value;
			if(value>1){
		        value--;
				$(this).closest('tr').find('input.daysVal').val(value);
		    }
		});
	});
</script>
<div class="pageheader">
	<div class="media">
        <div class="media-body">
    	<h4>Refund Voucher</h4>
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
	@if(!isset($_GET['token']))  
	<div class="row" style="margin-bottom: 20px">
		<div class="col-md-12">
			<form class="form-inline" method="get" action="">
				<div class="form-group" style="margin-right: 0">
					<input type="number" name="token" class="form-control" placeholder="*Receipt No" required="">
				</div>
				<button type="submit" class="btn btn-info">Find</button>
			</form>
		</div>
	</div>
	@else  
    <div class="row">
	    <div class="col-md-12">
	    	@include('flashmessage')
	    	<form method="post" action="{{ url('refund-voucher/partialupdate/'.$_GET['token']) }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Receipt No:</label>
					  <input type="text" class="form-control" value="{{$_GET['token']}}" disabled>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Voucher No:</label>
					    <input type="number" class="form-control" name="voucher_id" id="voucher_id" value="{{$voucher_id +1}}" disabled="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
				      <label>Voucher Date:</label>
					  <div class="input-group date">
						<input type="text" name="voucher_date" id="voucher_date" class="form-control" placeholder="Enter Voucher Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Payment Mode:</label>
					    <select class="form-control" name="payment_mode" id="payment_mode" required="" onchange="paymentMode(this.value);">
					    	<option value="Cash">Cash</option>
					    	<option value="Cheque" selected>Cheque</option>
					    	<option value="DD">DD</option>
					    	<option value="Direct Transfer">Direct Transfer</option>
					    </select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group" id="chequeNo_section">
					    <label>Cheque/DD No/Direct Txn No:</label>
					    <input type="text" class="form-control" placeholder="Enter Cheque/DD No/Direct Txn No:" name="cheque_no" id="cheque_no">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" id="chequeDate_section">
				      <label>Dated:</label>
					  <div class="input-group date">
						<input type="text" name="cheque_date" id="cheque_date" class="form-control" placeholder="Enter Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group" id="chequeDrawn_section">
					    <label>Drawn On:</label>
					    <input type="text" class="form-control" placeholder="Enter Drawn on" name="cheque_drawn" id="cheque_drawn">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive mb15">
						<table class="table table-bordered">
							<thead>
								<tr>
					                <td style="min-width: 100px"><b>Facility</b></td>
					                <td style="min-width: 100px"><b>Price</b></td>
					                <td style="min-width: 100px"><b>Quantity</b></td>
					                <td style="min-width: 100px"><b>No of Days</b></td>
					                <td style="min-width: 100px"><b>Amount</b></td>
					                <td style="min-width: 100px"><b>Deduction</b></td>
					            </tr>
							</thead>
							<tbody class="field_wrapper">
								@foreach($receiptfacility as $key=>$value)
								<tr>
					                <td>
					                  {{$value->facility_name}}
					                  <input type="hidden" name="facility_id[]" value="{{$value->facility_id}}">
					                </td>
					                <td>
										{{$value->booking_rate}}
										<input type="hidden" name="booking_rate[]" value="{{$value->booking_rate}}"/>
									</td>
									<td>
										{{$value->quantity}}
										<input type="hidden" name="quantity[]" value="{{$value->quantity}}"/>
									</td>
									<td>
										{{$value->noofdays}}
										<input class="daysVal" type="hidden" name="no_of_days[]" value="{{$value->noofdays}}"/>
									</td>
					                <td>
										{{$value->quantity*$value->noofdays*$value->booking_rate}}
										<input type="hidden" name="amount[]" value="{{$value->quantity*$value->noofdays*$value->booking_rate}}"/>
									</td>
					                <td>
									  <div class="form-group">
										<input type="number" name="deduction[]" class="form-control">
									  </div>
									</td>
					            </tr>
								@endforeach
								@if($receipt->misc_amount > 0)
								<tr>
					                <td>{{$receipt->misc}}</td>
					                <td>-</td>
					                <td>-</td>
					                <td>-</td>
					                <td>{{$receipt->misc_amount}}
									</td>
					                <td>
									  <div class="form-group">
										<input type="number" name="misc_deduction" class="form-control">
									  </div>
									</td>
					            </tr>
								@endif
								@if($receipt->others_amount > 0)
					            <tr>
					                <td>{{$receipt->others}}</td>
					                <td>-</td>
					                <td>-</td>
					                <td>-</td>
					                <td>{{$receipt->others_amount}}
									</td>
					                <td>
									  <div class="form-group">
										<input type="number" name="others_deduction" class="form-control">
									  </div>
									</td>
					            </tr>
								@endif
							</tbody>
						</table>
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
	@endif 
</div>
</div>
@endsection