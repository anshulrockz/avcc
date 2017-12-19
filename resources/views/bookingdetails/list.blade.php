@extends('layouts.website')
@section('content')
<?php
$from_date = date_format(date_create($from_date),"d-F-Y");
$to_date = date_format(date_create($to_date),"d-F-Y");
if($_POST && $_POST>0){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
}
?>
<script>
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
function printPage(){
	window.print();
}
</script>
<div class="pageheader">
	<div class="media">
		<div class="pull-right">
			<button onclick="printPage();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
		</div>
		<div class="media-body">
		<h4>Booking Details Report</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Reports</li>
		    <li>Booking Details Report</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">  
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" method="post" action="">
			{{ csrf_field() }}
				<div class="form-group" style="margin-right: 0">
					<div class="input-group date">
						<input type="text" name="from_date" class="form-control" value="{{$from_date}}" placeholder="Function From" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
					<div class="input-group date">
						<input type="text" name="to_date" class="form-control" value="{{$to_date}}" placeholder="Function To" required=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				</div>
				<button type="submit" name="submit" class="btn btn-info">Find</button>
			</form>
		</div>
	</div>     
    <div class="row" style="margin-top: 10px">
	    <div class="col-md-12">
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
		  <h4 class="center onlyprint">ARUN VIHAR COMMUNITY CENTER </h4>
		  <h5 class="center onlyprint">SECTOR 37, NOIDA</h5>
		  <h4 class="center-underline onlyprint">Booking Details Report</h4>
		  	@if($_POST && $_POST>0)
		  	<h5 class="center-print"><strong>Function From: {{$from_date}}, Function To: {{$to_date}}</strong></h5>
		  	@endif
		    <div class="table-responsive">
			  <table class="table table-bordered" style="border: 1px solid #ddd; margin-top: 15px">
			    <thead>
			      <tr>
			      	<th>Facility</th>
			      	<?php
			      	$date_range = dateRange_custom($from_date, $to_date);
					for($i=0; $i<count($date_range); $i++){ ?>
			      	<th>{{date_format(date_create($date_range[$i]),"d F")}}</th>
			      	<?php }?>
			      </tr>
			    </thead>
			       <?php 
			       $facB=array();
			        foreach ($facility_booking as $value){
		          	$facB[$value->from_date][$value->facility_id]=$value;
		          };?>
			    <tbody>
			      @foreach ($facility as $key=>$value)
		          <tr>
		          	<td>{{$value->name}}</td>
		          	<?php for($i=0; $i<count($date_range); $i++){ ?>
			      	<td>
			      	<?php
			      	if(isset($facB[$date_range[$i]])){
						foreach($facB[$date_range[$i]] as $key=>$val){
							if($key==$value->id)
							echo "Booked";
						}
					}
			        ?>
			        </td>
			      	<?php }?>
		          </tr>
		          @endforeach
			    </tbody>
			  </table>
			</div
		</div>
	</div>
</div>
</div>
@endsection