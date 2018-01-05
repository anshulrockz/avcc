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
            <li>{{$receipt[0]->receipt_no}}</li>
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
          @include('receipt.view-catering')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '5'){ ?>
          @include('receipt.view-rent')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '6'){ ?>
          @include('receipt.view-corpus-fund')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '7'){ ?>
          @include('receipt.view-security')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '8'){ ?>
          @include('receipt.view-rebate')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '9'){ ?>
          @include('receipt.view-fd')
          <?php }?>
          <?php if($receipt[0]->receipt_type == '10'){ ?>
          @include('receipt.view-others')
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