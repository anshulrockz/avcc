@extends('layouts.website')
@section('content')
<script>
	function printReceipt() {
	    document.title = "Advance Receipt";
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
		<div class="pull-right">
			<button onclick="printReceipt();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
		</div>
        <div class="media-body">
    	<h4>View Receipt</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li><a href="{{ url('/receipt') }}">Receipt</a></li>
            <li>View</li>
            <li>{{$receipt[0]->id}}</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel" style="margin-bottom: 0px">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-12">
	    	<h4 class="center">ARUN VIHAR COMMUNITY CENTRE </h4>
	    	<h5 class="center-underline">SECTOR 37, NOIDA</h5>
	    	<h5 class="center">TEL: 2430288, 4273446 </h5>
	    	<h5 class="center">GSTIN: 09AAAAA3742LIZQ, Email ID: avcc1993@gmail.com </h5>
		  <div class="table-responsive">
	          <table class="table mb30">
	            <thead>
	              <tr>
	                <th class="facility-th" colspan="4">Booking Entry</th>
	              </tr>
	            </thead>
	            <tbody>
	              <tr>
	                <td class="facility-td"><b>Receipt No/Date:</b></td>
	                @if($receipt[0]->receipt_type == '8')
	                <td class="facility-td"><?php echo $receipt_rebate->rebate_no.'/'.date_dfy($receipt[0]->created_at); ?></td>
	                @else
	                <td class="facility-td"><?php echo $receipt[0]->id.'/'.date_dfy($receipt[0]->created_at); ?></td>
	                @endif
	                <td class="facility-td"><b>Booking No/Date:</b></td>
	                <?php if(!empty($receipt[0]->booking_no)){ ?>
	                <td class="facility-td"><?php echo $receipt[0]->booking_no.'/'.date_dfy($receipt[0]->booking_date); ?></td>
	                <?php }?>
	              </tr>
	              <tr>
	              	@if($receipt[0]->receipt_type == '5')
	              	<td class="facility-td"><b>Party Name:</b></td>
	              	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
	              	@elseif($receipt[0]->receipt_type == '6')
	              	<td class="facility-td"><b>Bank Name:</b></td>
	              	<td class="facility-td"><?php echo $receipt[0]->party_name; ?></td>
	              	@else
	              	<td class="facility-td"><b>Membership No/Party Name:</b></td>
	                <td class="facility-td"><?php echo $receipt[0]->membership_no.'/'.$receipt[0]->party_name; ?></td>
	              	@endif
	              	
	              	@if($receipt[0]->receipt_type == '6')
	              	<td class="facility-td"><b>Bank GSTIN:</b></td>
	              	@else
	              	<td class="facility-td"><b>Party GSTIN:</b></td>
	              	@endif
	                <td class="facility-td">{{$receipt[0]->party_gstin}}</td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Reverse Charges:</b></td>
	                <td class="facility-td">@if($receipt[0]->reverse_charges == '1') Yes @else No @endif</td>
	                <td class="facility-td"><b>Function Date:</b></td>
	                <td class="facility-td"><?php echo date_dfy($receipt[0]->function_date); ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Phone:</b></td>
	                <td class="facility-td"><?php echo $receipt[0]->phone; ?></td>
	                <td class="facility-td"><b>Mobile:</b></td>
	                <td class="facility-td"><?php echo $receipt[0]->mobile; ?></td>
	              </tr>
	              <tr>
	                <td class="facility-td"><b>Address:</b></td>
	                <td class="facility-td"><?php echo $receipt[0]->address; ?></td>
	                <td class="facility-td"><b>Payment Mode:</b></td>
	                @if($receipt[0]->payment_mode == 'Cheque' || $receipt[0]->payment_mode == 'DD')
	                <td class="facility-td"><?php echo $receipt[0]->payment_mode.'/'.$receipt[0]->cheque_no.'/'.date_dfy($receipt[0]->cheque_date).'/'.$receipt[0]->cheque_drawn; ?></td>
	                @else
	                <td class="facility-td"><?php echo $receipt[0]->payment_mode; ?></td>
	                @endif
	              </tr>
	              
	              <tr>
	              @if($receipt[0]->receipt_type == '3' || $receipt[0]->receipt_type == '8')
	                <td class="facility-td"><b>Contractor Name:</b></td>
	                <td class="facility-td"><?php echo $contractor->getContractorName($receipt[0]->contractor_id); ?></td>
	              @endif
	              @if($receipt[0]->receipt_type == '3' || $receipt[0]->receipt_type == '4')
	                <td class="facility-td"><b>Comments:</b></td>
	                <td class="facility-td"><?php echo $receipt[0]->comments; ?></td>
	              @endif
	              </tr>
	            </tbody>
	          </table>
          </div>
          <?php if($receipt[0]->receipt_type == '1'){ ?>
          @include('receipt.view-booking')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '2'){ ?>
          @include('receipt.view-stl')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '3'){ ?>
          @include('receipt.view-tentage')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '4'){ ?>
          @include('receipt.view-others')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '5'){ ?>
          @include('receipt.view-rent')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '6'){ ?>
          @include('receipt.view-fd')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '8'){ ?>
          @include('receipt.view-rebate')
          <?php }?>
          <div style="float: left; margin-top: 20px; font-weight: bold;">
          	(Signature of the Member)
          </div>
          <div style="float: right; margin-top: 20px; font-weight: bold;">
          	(Accountant/Cashier)
          </div>
          <div style="clear:both"></div>
          <!--<div style="margin-top: 20px">
          	*Contribution to the Corpus Fund is being made by the Member with the specific direction that it shall form part of the Corpus Fund of AVCC and shall accordingly be used for creating and improvement of its infrastructural activities in the long term public interest.
          </div>-->
      	</div>
	</div>
</div>
</div>
@endsection