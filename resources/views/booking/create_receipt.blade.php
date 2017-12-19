@extends('layouts.website')
@section('content')
<script>
	function printReceipt() {
	    document.title = "Receipt";
	    window.print();
	}
	function calculateTotal() {
		var subTotal = $('.subTotal').text();
	    var serviceTax = $('.serviceTax').text();
	    var vat = $('.vat').text();
	    var tax = 0;
	    if($('#incl_st').prop("checked") == true){
			tax += parseFloat(serviceTax);
			$(".st-row").removeClass("no-print");
        }
        if($('#incl_st').prop("checked") == false){
			$(".st-row").addClass("no-print");
			
        }
        if($('#incl_vat').prop("checked") == true){
			tax += parseFloat(vat);
			$(".vat-row").removeClass("no-print");
        }
        if($('#incl_vat').prop("checked") == false){
			$(".vat-row").addClass("no-print");
			
        }
        var total = parseFloat(subTotal)+parseFloat(tax);
        $('.total').html('<b>'+total.toFixed(2)+'</b>');
	}
</script>
<div class="pageheader">
		<div class="media">
		<div class="pageicon pull-left">
            <i style="padding: 10px 0 0 0;" class="fa fa-book"></i>
        </div>
		<div class="pull-right">
			<button onclick="printReceipt();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
		</div>
        <div class="media-body">
    	<h4>Receipt</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/booking') }}">Booking</a></li>
            <li><a href="{{ url('/receipt') }}">Receipt</a></li>
            <li>{{$booking[0]->id}}</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    	<h4 class="center">ARUN VIHAR COMMUNITY CENTER </h4>
	    	<h5 class="center-underline">SECTOR 37, NOIDA</h5>
	    	<h5 class="center">TEL: 2430288, 4273446 </h5>
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
	              <!--<tr>
	                <td class="facility-td"><b>Bill No:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->bill_no; ?></td>
	                <td class="facility-td"><b>Bill Date:</b></td>
	                <td class="facility-td"><?php echo date_dfy($booking[0]->bill_date); ?></td>
	              </tr>-->
	              <!--<tr>
	                <td class="facility-td"><b>Member:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->member_name; ?></td>
	                <td class="facility-td"><b>Member Type:</b></td>
	                <td class="facility-td"><?php echo $booking[0]->member_type; ?></td>
	              </tr>-->
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
	            </tbody>
	          </table>
          </div>
		  <div class="table-responsive">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="17">Booking Details</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
	                <td style="min-width: 100px" class="left-align"><b>S.No</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Particular</b></td>
	                <td style="min-width: 100px" class="left-align"><b>No of Days</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Amount</b></td>
	                <td style="min-width: 100px" class="left-align"><b>Total</b></td>
	              </tr>
	              <?php $i = 1; ?>
	              @foreach ($booking_facility as $value)
	              <tr>
	                <td class="left-align">{{ $i }}</td>
	                <td class="left-align">{{ $value->facility_name }}</td>
	                <td class="left-align">{{ $value->noofdays }}</td>
	                <td class="left-align">{{ $value->booking_rate }}</td>
	                <td class="left-align">{{ number_format((float)$value->booking_rate*$value->noofdays, 2, '.', '') }}</td>
	              </tr>
	              <?php $i++; ?>
	              @endforeach
	              <tr>
	                <td class="left-align">{{ $i }}</td>
	                <td class="left-align">Safai &amp; General</td>
	                <td class="left-align">-</td>
	                <td class="left-align">-</td>
	                <td class="left-align">{{$safai_charges}}</td>
	              </tr>
	              <tr>
	                <td class="left-align">{{ $i+1 }}</td>
	                <td class="left-align">Generator</td>
	                <td class="left-align">-</td>
	                <td class="left-align">-</td>
	                <td class="left-align">{{$generator_charges}}</td>
	              </tr>
	              <tr>
	                <td class="left-align">{{ $i+2 }}</td>
	                <td class="left-align">Security</td>
	                <td class="left-align">-</td>
	                <td class="left-align">-</td>
	                <td class="left-align">{{$security_charges}}</td>
	              </tr>
	              <?php if($booking[0]->misc != ''){ ?>
	              <tr>
	                <td class="left-align">{{ $i+3 }}</td>
	                <td class="left-align">{{$booking[0]->misc}}</td>
	                <td class="left-align">-</td>
	                <td class="left-align">-</td>
	                <td class="left-align">{{$booking[0]->misc_amount}}</td>
	              </tr>
	              <?php }?>
	              <tr>
	                <td colspan="4" class="right-align">Sub-Total:</td>
	                <td class="left-align subTotal"><b>{{number_format((float)$sub_total, 2, '.', '')}}</b></td>
	              </tr>
	              <?php if($booking[0]->tax_status == '1'){ ?>
	              <tr>
	                <td style="border-top: none" colspan="4" class="right-align">CGST:</td>
	                <td style="border-top: none" class="left-align serviceTax"><b>{{$booking[0]->service_tax}}</b></td>
	              </tr>
	              <tr>
	                <td style="border-top: none" colspan="4" class="right-align">SGST:</td>
	                <td style="border-top: none" class="left-align vat"><b>{{$booking[0]->vat}}</b></td>
	              </tr>
	              <tr>
	                <td style="border-top: none" colspan="4" class="right-align">Total:</td>
	                <td style="border-top: none" class="left-align total"><b>{{$booking[0]->total_amount}}</b></td>
	              </tr>
	              <?php } else{?>
	              <tr>
	                <td style="border-top: none" colspan="4" class="right-align">Total:</td>
	                <td style="border-top: none" class="left-align total"><b>{{number_format((float)$sub_total, 2, '.', '')}}</b></td>
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