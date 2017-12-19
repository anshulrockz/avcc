@extends('layouts.website')
@section('content')
<div class="pageheader">
	<div class="media">
		<div class="pageicon pull-left">
            <i style="padding: 8px 0 0 0;" class="fa fa-calendar"></i>
        </div>
		<div class="media-body">
		<h4>Booking Calendar</h4>
		<ul class="breadcrumb">
		    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
		    <li>Booking Calendar</li>
		</ul>
		</div>
	</div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    	<div id="calendar"></div>
		</div>
	</div>
</div>
</div>
<?php
$events=array();
foreach($booking as $value){	
	$events[]=array('start'=>$value->function_date,'title'=>'Booking No: '.$value->booking_no,'description'=>'Function Type: '.$value->function_type.', Timings: '.am_pm($value->from_time).' to '.am_pm($value->to_time));
} 
?>
<script>
<?php echo 'var allevents='.json_encode($events).';';?>
	$(document).ready(function() {
	    $('#calendar').fullCalendar({
	    	eventLimit: 3,
	        events: allevents,
//			eventMouseover:  function(event, jsEvent, view) {
//		        alert(event.description);
//		    }
			eventRender: function(event, element) {
		        element.attr('title', event.description);
		    }
	    });
	});
</script>
@endsection