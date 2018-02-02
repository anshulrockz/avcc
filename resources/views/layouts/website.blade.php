<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>AVCC</title>
    <link href="{{ url('/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ url('/css/style.print.css') }}" rel="stylesheet">
    <link href="{{ url('/css/jquery.tagsinput.css') }}" rel="stylesheet">
    <link href="{{ url('/css/select2.css') }}" rel="stylesheet">
    <!--Data Table-->
	<link href="{{ url('/datatable/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ url('/datatable/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
	
	<script src="{{ url('/js/jquery-1.11.1.min.js') }}"></script>
	<link href="{{ url('/datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet"/>
	<script src="{{ url('/datepicker/bootstrap-datepicker.min.js') }}"></script>
	<link href="{{ url('/timepicker/bootstrap-clockpicker.css') }}" rel="stylesheet">
	<script src="{{ url('/timepicker/bootstrap-clockpicker.js') }}"></script>
	
	<script type="text/javascript" src="{{ url('/timepicker2/jquery.timepicker.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ url('/timepicker2/jquery.timepicker.css') }}" />
	
	<link href="{{ url('/css/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
	
	<link href="{{ url('/css/fullcalendar.css') }}" rel="stylesheet">
	
    <style>
    	footer{
			position: relative;
			width: 100%;
			bottom: 0;
			background: #fff;
			padding: 15px;
			text-align: center;
			border-top: 1px solid #eee;
		}
		.footer{
			margin: 0px;
			line-height: 32px;
		}
		td,th{
			vertical-align: middle !important;
		text-align: center;
		}
		.badge{
			margin-bottom: 3px;
		}
    </style>
    </head>
    <body> 
    <header>
        <div class="headerwrapper">
            <div class="header-left">
                <a style="color: #fff;font-size: 18px; margin-top: 2px" href="{{ url('/') }}" class="logo">
                    Admin Panel
                </a>
                <div class="pull-right">
                    <a href="" class="menu-collapse">
                        <i style="font-size: 17px;" class="fa fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="header-right">
                <div class="pull-right">
                    <div class="btn-group btn-group-option">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <i class="fa fa-user"></i>
                        </button>
                        <ul class="dropdown-menu pull-right">
                          <li><a href="{{ url('/editprofile') }}"><i class="glyphicon glyphicon-user"></i> Edit Profile</a></li>
                          <li><a href="{{ url('/changepassword') }}"><i class="glyphicon glyphicon-cog"></i> Change Password</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out"></i>Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
      <div class="mainwrapper">
        <div class="leftpanel">
            <div class="media profile-left">
                <a onclick="return false;" class="pull-left profile-thumb" href="" style="cursor: default;">
                    <?php if(Auth::user()->image != ''){ ?>
                    <img class="img-circle" src="{{ url('/uploads/'.Auth::user()->image) }}" alt="">
                    <?php } else{?>
                    <img class="img-circle" src="{{ url('/images/default_thumb.png') }}" alt="">
                    <?php }?>
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{Auth::user()->name}}</h4>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>    
            <ul class="nav nav-pills nav-stacked" id="navMenus">
                <li><a href="{{ url('') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                <li class="parent"><a href=""><i class="fa fa-info"></i> <span>Masters</span></a>
                    <ul class="children">
                        <li><a href="{{ url('/accounthead') }}">Account Head</a></li>
                        <li><a href="{{ url('/bank') }}">Bank</a></li>
                        <li><a href="{{ url('/contractor') }}">Contractor</a></li>
                        <li><a href="{{ url('/facility') }}">Facility</a></li>
                        <li><a href="{{ url('/facilitytype') }}">Facility Type</a></li>
                        <li><a href="{{ url('/member') }}">Member</a></li>
                        <li><a href="{{ url('/membertype') }}">Member Type</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/booking') }}"><i class="fa fa-book"></i> <span>Booking</span></a></li>
                <!--<li><a href="{{ url('/receipt-stl') }}"><i class="fa fa-tint"></i> <span>Tax Liability</span></a></li>-->
                <li class="parent"><a href="{{ url('/receipt') }}"><i class="fa fa-file-text-o"></i> <span>Receipt</span></a>
                    <ul class="children">
                    	<li><a href="{{ url('/receipt') }}">All Receipts</a></li>
                    	<li><a href="{{ url('/receipt-booking') }}">Booking Receipts</a></li>
                    	<li><a href="{{ url('/receipt-tentage') }}">Tentage Receipts</a></li>
                    	<li><a href="{{ url('/receipt-catering') }}">Catering Receipts</a></li>
                    	<li><a href="{{ url('/receipt-rent') }}">Rent Receipts</a></li>
                    	<li><a href="{{ url('/receipt-corpusfund') }}">Corpus Fund Receipts</a></li>
                    	<li><a href="{{ url('/receipt-fd') }}">FD Receipts</a></li>
                    	<li><a href="{{ url('/receipt-rebate') }}">Rebate Receipts</a></li>
                    	<li><a href="{{ url('/receipt-others') }}">Other Receipts</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/calendar') }}"><i class="fa fa-calendar"></i> <span>Booking Calendar</span></a></li>
                <li><a href="{{ url('/refund-voucher') }}"><i class="fa fa-file-excel-o"></i> <span>Refund Voucher</span></a>
                    <!--class="parent" <ul class="children"> 
                        <li><a href="{{ url('/refund-voucher') }}"> Voucher</a></li>
                        <li><a href="{{ url('/debit-voucher') }}">Debit Voucher</a></li>
                    </ul> -->
                </li>
                <li class="parent"><a href=""><i class="fa fa-file-word-o"></i> <span>Reports</span></a>
                    <ul class="children" style="margin-bottom: 20px">
                    	<li><a href="{{ url('/securityamount-register') }}">Security Amount Register</a></li>
                        <li><a href="{{ url('/servicetax-register') }}">CGST Register</a></li>
                        <li><a href="{{ url('/vat-register') }}">SGST Register</a></li>
                        <li><a href="{{ url('/booking-register') }}">Booking Register</a></li>
                        <li><a href="{{ url('/booking-details') }}">Booking Details Report</a></li>
                        <li><a href="{{ url('/booking-cancellation') }}">Booking Cancellation</a></li>
                        <li><a href="{{ url('/memberlist-report') }}">Member List Report</a></li>
                        <li><a href="{{ url('/tentage-register') }}">Tentage Register</a></li>
                        <li><a href="{{ url('/catering-register') }}">Catering Register</a></li>
                        <li><a href="{{ url('/rebate-register') }}">Rebate Register</a></li>
                        <li><a href="{{ url('/tds-register') }}">TDS Register</a></li>
                    </ul>
                </li>
                <!--<li><a href="{{ url('/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>-->
            </ul>    
        </div>
        <div class="mainpanel">
        @yield('content')
        </div>
      </div>
    </section>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/custom.js') }}"></script>
    <!--Data Table-->
	<script src="{{ url('/datatable/jquery.dataTables.min.js') }}"></script>
	<script src="{{ url('/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ url('/datatable/dataTables.buttons.min.js') }}"></script>
	<script src="{{ url('/datatable/buttons.flash.min.js') }}"></script>
	<script src="{{ url('/datatable/jszip.min.js') }}"></script>
	<script src="{{ url('/datatable/pdfmake.min.js') }}"></script>
	<script src="{{ url('/datatable/vfs_fonts.js') }}"></script>
	<script src="{{ url('/datatable/buttons.html5.min.js') }}"></script>
	<script src="{{ url('/datatable/buttons.print.min.js') }}"></script>
	
	<script src="{{ url('/js/jquery.tagsinput.min.js') }}"></script>
	<script src="{{ url('/js/select2.min.js') }}"></script>
	<script src="{{ url('/js/fancybox/jquery.fancybox.js') }}"></script>
	<script src="{{ url('/js/bootstrap-wizard.min.js') }}"></script>
	<script src="{{ url('/js/jquery.validate.min.js') }}"></script>
	<script src="{{ url('/js/moment.min.js') }}"></script>
	<script src="{{ url('/js/fullcalendar.js') }}"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	  $(".multiple-select").select2();
	  var wH=$(window).height();
	  var lpH=wH-60;
	  $('.leftpanel').css('height',lpH);
	});
	</script>
    </body>
</html>