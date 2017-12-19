@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>Update Contractor</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/contractor') }}">Contractor</a></li>
            <li>Edit</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	    <div class="col-md-6">
		@include('flashmessage')
      	<form method="post" action="{{ url('/contractor/update/'.$contractor[0]->id) }}">
      	{{ csrf_field() }}
		  <div class="form-group">
		    <label>*Name:</label>
		    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo $contractor[0]->name; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>Phone:</label>
		    <input type="text" class="form-control" placeholder="Enter phone" name="phone" id="phone" value="<?php echo $contractor[0]->phone; ?>">
		  </div>
		  <div class="form-group">
		    <label>Mobile:</label>
		    <input type="text" class="form-control" placeholder="Enter mobile" name="mobile" id="mobile" value="<?php echo $contractor[0]->mobile; ?>">
		  </div>
		  <div class="form-group">
		    <label>*Address 1:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address1" id="address1" value="<?php echo $contractor[0]->address1; ?>" required="">
		  </div>
		  <div class="form-group">
		    <label>Address 2:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address2" id="address2" value="<?php echo $contractor[0]->address2; ?>">
		  </div>
		  <div class="form-group">
		    <label>Address 3:</label>
		    <input type="text" class="form-control" placeholder="Enter address" name="address3" id="address3" value="<?php echo $contractor[0]->address3; ?>">
		  </div>
		  <div class="form-group">
		    <label>Opening Balance:</label>
		    <input type="number" class="form-control" placeholder="Enter opening balance" name="op_balance" id="op_balance" step="0.01" value="<?php echo slash_decimal($contractor[0]->op_balance); ?>">
		  </div>
		  <div class="form-group">
		      <label>Op.Balance Date:</label>
			  <div class="input-group date">
				<input type="text" name="opbalance_date" id="opbalance_date" value="<?php echo date_dfy($contractor[0]->opbalance_date); ?>" class="form-control" placeholder="Enter opening balance date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			  </div>
		  </div>
		  <div class="form-group">
		    <label>Rebate (%):</label>
		    <input type="number" class="form-control" placeholder="Enter rebate" name="rebate" id="rebate" step="0.01" value="<?php echo slash_decimal($contractor[0]->rebate); ?>">
		  </div>
		  <button type="submit" class="btn btn-primary">Update</button>
		</form>
		</div>
	</div>
</div>
</div>
@endsection