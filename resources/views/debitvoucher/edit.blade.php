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
    //startDate: today
});  
});
</script>
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Debit Voucher</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/debit-voucher') }}">Debit Voucher</a></li>
            <li>Edit</li>
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
		<form method="post" action="{{ url('debit-voucher/update/'.$voucher[0]->id) }}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Voucher ID:</label>
					    <input type="number" class="form-control" name="voucher_id" id="voucher_id" value="{{$voucher[0]->id}}" disabled="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>*Voucher Date:</label>
					  <div class="input-group date">
						<input type="text" name="voucher_date" id="voucher_date" value="{{date_dfy($voucher[0]->voucher_date)}}" class="form-control" placeholder="Enter Voucher Date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*R.V No:</label>
					    <input type="number" class="form-control" name="rv_no" id="rv_no" value="{{$voucher[0]->rv_no}}" placeholder="Enter R.V Number" required="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>*R.V Date:</label>
					  <div class="input-group date">
						<input type="text" name="rv_date" id="rv_date" value="{{date_dfy($voucher[0]->rv_date)}}" class="form-control" placeholder="Enter R.V Date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Party Name:</label>
					    <input type="text" class="form-control" name="party_name" id="party_name" value="{{$voucher[0]->party_name}}" placeholder="Enter Party Name" required="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>*Function Date:</label>
					  <div class="input-group date">
						<input type="text" name="function_date" id="function_date" value="{{date_dfy($voucher[0]->function_date)}}" class="form-control" placeholder="Enter Function Date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Cheque No:</label>
					    <input type="text" class="form-control" name="cheque_no" id="cheque_no" value="{{$voucher[0]->cheque_no}}" placeholder="Enter Cheque Number" required="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
				      <label>*Cheque Date:</label>
					  <div class="input-group date">
						<input type="text" name="cheque_date" id="cheque_date" value="{{date_dfy($voucher[0]->cheque_date)}}" class="form-control" placeholder="Enter Cheque Date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					  </div>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					      <label>*A/C Head:</label>
					      <select class="form-control" name="account_head" id="account_head" required="">
					      		@foreach ($ac_head as $value)
					      		<option value="{{ $value->id }}" <?php if($voucher[0]->achead_id==$value->id){ ?> selected="" <?php }?>>{{ $value->name }}</option>
					      		@endforeach
					      </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					      <label>*Paid To:</label>
					      <select class="form-control" name="paid_to" id="paid_to" required="">
					      		@foreach ($paid_to as $value)
					      		<option value="{{ $value->id }}" <?php if($voucher[0]->paid_to==$value->id){ ?> selected="" <?php }?>>{{ $value->name }}</option>
					      		@endforeach
					      </select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Security Amount:</label>
					    <input type="number" class="form-control" name="security_amount" id="security_amount" value="{{$voucher[0]->security_amount}}" placeholder="Enter Security Amount" required="">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>*Remarks:</label>
					    <input type="text" class="form-control" name="remarks" id="remarks" value="{{$voucher[0]->remarks}}" placeholder="Enter Remarks" required="">
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