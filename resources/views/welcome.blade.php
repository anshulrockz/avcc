@extends('layouts.website')

@section('content')

<div class="pageheader">
		<div class="media">
        <div class="pageicon pull-left">
            <i class="fa fa-home"></i>
        </div>
        <div class="media-body">
    	<h4>Dashboard</h4>
        <ul class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Dashboard</li>
        </ul>
    	</div>
    </div><!-- media -->
</div><!-- pageheader -->
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row row-stat">
        <div class="col-md-4">
            <div class="panel panel-primary-head noborder">
                <div class="panel-heading noborder">
                    <div class="panel-icon"><i class="fa fa-users"></i></div>
                    <div class="media-body">
                        <h5 class="md-title nomargin">Members Joined</h5>
                        <h1 class="mt5">{{$members_joined}}</h1>
                    </div>
                    <hr>
                    <div class="clearfix mt20">
                        <div class="pull-left">
                            <h5 class="md-title nomargin">Yesterday</h5>
                            <h4 class="nomargin">{{$membersjoined_yesterday}}</h4>
                        </div>
                        <div class="pull-right">
                            <h5 class="md-title nomargin">This Week</h5>
                            <h4 class="nomargin">{{$membersjoined_thisweek}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-custom-head1 noborder">
                <div class="panel-heading noborder">
                    <div class="panel-icon"><i style="padding: 12px 0 0 14px;" class="fa fa-book"></i></div>
                    <div class="media-body">
                        <h5 class="md-title nomargin">Booking Done</h5>
                        <h1 class="mt5">{{$booking_done}}</h1>
                    </div>
                    <hr>
                    <div class="clearfix mt20">
                        <div class="pull-left">
                            <h5 class="md-title nomargin">Yesterday</h5>
                            <h4 class="nomargin">{{$bookingdone_yesterday}}</h4>
                        </div>
                        <div class="pull-right">
                            <h5 class="md-title nomargin">This Week</h5>
                            <h4 class="nomargin">{{$bookingdone_thisweek}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-custom-head2 noborder">
                <div class="panel-heading noborder">
                    <div class="panel-icon"><i style="padding: 12px 0 0 14px;" class="fa fa-file-text-o"></i></div>
                    <div class="media-body">
                        <h5 class="md-title nomargin">Receipt Created</h5>
                        <h1 class="mt5">{{$receipt_created}}</h1>
                    </div>
                    <hr>
                    <div class="clearfix mt20">
                        <div class="pull-left">
                            <h5 class="md-title nomargin">Yesterday</h5>
                            <h4 class="nomargin">{{$receiptcreated_yesterday}}</h4>
                        </div>
                        <div class="pull-right">
                            <h5 class="md-title nomargin">This Week</h5>
                            <h4 class="nomargin">{{$receiptcreated_thisweek}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
			    <div class="panel-heading">Latest Members</div>
			    <div class="panel-body table-responsive">
			    	@if($latestmembers_count>0)
			    	<table class="table table-bordered" style="border: 1px solid #ddd">
					    <thead>
					      <tr>
					        <th>Membership No</th>
					        <th>Member Type</th>
					        <th>Name</th>
					        <th>Mobile</th>
					      </tr>
					    </thead>
    					<tbody>
    					  @foreach ($latest_members as $value)
					      <tr>
					        <td>{{$value->membership_no}}</td>
					        <td>{{$value->membertype_name}}</td>
					        <td>{{$value->name}}</td>
					        <td>{{$value->mobile}}</td>
					      </tr>
					      @endforeach
					    </tbody>
 					 </table>
 					 @else
 					 <p>No results found!</p>
 					 @endif
			    </div>
			</div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
			    <div class="panel-heading">Latest Bookings</div>
			    <div class="panel-body table-responsive">
			    	@if($latestbookings_count>0)
			    	<table class="table table-bordered" style="border: 1px solid #ddd">
					    <thead>
					      <tr>
					        <th>Booking Form No</th>
					        <th>Booking Date</th>
					        <th>Party Name</th>
					        <th>Function Date</th>
					      </tr>
					    </thead>
    					<tbody>
    					  @foreach ($latest_bookings as $value)
					      <tr>
					        <td>{{$value->booking_no}}</td>
					        <td>{{date_dfy($value->booking_date)}}</td>
					        <td>{{$value->party_name}}</td>
					        <td>{{date_dfy($value->function_date)}}</td>
					      </tr>
					      @endforeach
					    </tbody>
 					 </table>
 					 @else
 					 <p>No results found!</p>
 					 @endif
			    </div>
			</div>
        </div>
    </div>
</div>
</div>
@endsection