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
		<div class="pageicon pull-left">
            <i style="padding: 10px 0 0 0;" class="fa fa-book"></i>
        </div>
		<?php if(Auth::user()->user_group == '1'){ ?>
		<div class="pull-right">
			<a href="{{ url('/booking/add') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Booking</button></a>
		</div>
		<?php }?>
		<div class="media-body">
		<h4>Booking</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Booking</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    @include('flashmessage')
		<?php if($count>0){ ?>
		  <table class="table table-bordered" id="dataTable">
		    <thead>
		      <tr>
		        <th>Booking Form No</th>
		      	<th>Booking Date</th>
		      	<th>Party Name</th>
		      	<th>Function Date</th>
		      	<th>Function Time</th>
		        <th>Function Type</th>
		        <th>Status</th>
		        <th style="width: 150px">Action</th>
		      </tr>
		    </thead>
		    <tbody>
		      @foreach ($booking as $value)
	          <tr>
	            <td>{{ $value->booking_no }}</td>
	          	<td>{{ date_dfy($value->booking_date) }}</td>
	          	<td>{{ $value->party_name }}</td>
	          	<td>{{ date_dfy($value->function_date) }}</td>
	            <td>{{ am_pm($value->from_time).' - '. am_pm($value->to_time)}}</td>
	            <td>{{ $value->function_type }}</td>
	            @if($value->booking_status == '0')
	            <td><span class="label label-warning">Pending</span></td>
	            @elseif($value->booking_status == '1')
	            <td><span class="label label-success">Booked</span></td>
	            @elseif($value->booking_status == '2')
	            <td><span class="label label-danger">Cancelled</span></td>
	            @endif
	            <td>
	            <a href="{{ url('/booking/view/'.$value->id) }}" data-toggle="tooltip" title="View" class="btn btn-info" data-original-title="View"><i class="fa fa-eye"></i></a>
	            @if($value->booking_status == '0')
	            <a href="{{ url('/booking/edit/'.$value->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
	            <a onclick="return confirm('Are you sure you want to Delete?');" href="{{ url('/booking/delete/'.$value->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
	            @endif
	            @if($value->booking_status == '1')
	            <a href="{{ url('/booking/partialedit/'.$value->id) }}" title="Edit" class="btn btn-warning" data-original-title="Edit"><i class="fa fa-plus-circle"></i></a>
	            <a href="javascript:" data-toggle="modal" data-target="#cancelModal{{ $value->id }}" title="Full Cancel" class="btn btn-danger" data-original-title="Full Cancel"><i class="fa fa-times "></i></a>
	            @endif
	            <div class="modal fade cancelModal" id="cancelModal{{ $value->id }}" tabindex="-1" role="dialog">
		            <div class="modal-dialog">
		              <div class="modal-content">
		                  <div class="modal-header">
		                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
		                      <h4 class="modal-title">Cancel Booking</h4>
		                  </div>
		                  <form class="form-vertical" method="post" action="{{ url('booking/cancel/'.$value->id) }}">
		                  {{ csrf_field() }}
		                  <div class="modal-body">
		                  	  <div class="form-group">
							      <label class="popup_label">*Cancel Date:</label>
								  <div class="input-group date">
									<input type="text" name="cancel_date" id="cancel_date" class="form-control " placeholder="Enter cancel date" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								  </div>
							  </div>
							  <div class="form-group">
							    <label class="popup_label">Cancel (%):</label>
							    <input type="number" class="form-control popup_input" placeholder="Enter cancel percentage" name="cancel_percentage" id="cancel_percentage" step="0.01">
							  </div>
							  <!--<div class="form-group">
							    <label class="popup_label">Cancel (Amt):</label>
							    <input type="number" class="form-control popup_input" placeholder="Enter cancel amount" name="cancel_amount" id="cancel_amount">
							  </div>-->
							  <?php if($value->booking_status == '1'){ ?>
							  <div><b>Note:</b> The associated Receipt ID: {{$value->receipt_id}} will be auto cancelled with Booking ID: {{$value->id}}</div>
							  <?php }?>
		                  </div>
		                  <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-primary">Cancel Booking</button>
					      </div>
					      </form>
		              </div>
		            </div>
		        </div>
	            </td>
	          </tr>
	          @endforeach
		    </tbody>
		  </table>
		<?php } else{?>
		<p>No results found!</p>
		<?php }?>
		</div>
	</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
    	"ordering": false
    });
});
</script>
@endsection