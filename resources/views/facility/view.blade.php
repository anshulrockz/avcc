@extends('layouts.website')
@section('content')
<div class="pageheader">
		<div class="media">
        <div class="media-body">
    	<h4>View Facility</h4>
        <ul class="breadcrumb">
            <li><a href="{{url('')}}"><i class="glyphicon glyphicon-home"></i></a></li>
            <li>Masters</li>
            <li><a href="{{ url('/facility') }}">Facility</a></li>
            <li>View</li>
        </ul>
    	</div>
    </div>
</div>
<div class="contentpanel">
<div id="page-wrapper">       
    <div class="row">
	  <div class="col-md-4 table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="2">Facility</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="facility-td"><b>Type:</b></td>
                <td class="facility-td"><?php echo $facilitytype[0]->facility_type; ?></td>
              </tr>
              <tr>
                <td class="facility-td"><b>Name:</b></td>
                <td class="facility-td"><?php echo $facility[0]->name; ?></td>
              </tr>
              <tr>
                <td class="facility-td"><b>SAC Code:</b></td>
                <td class="facility-td"><?php echo $facility[0]->sac_code; ?></td>
              </tr>
              <tr>
                <td class="facility-td"><b>Taxes:</b></td>
                <td class="facility-td">
                <?php if(count($facility_tax)>0){?>
                @foreach ($facility_tax as $value)
                <span class="badge">{{$value->tax_name}}</span>
                @endforeach
                <?php }?>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
	  <div class="col-md-5 table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="4">Rebate for AVCC</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="facility-td"><b>Safai (Amt):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_safai) }}</td>
                <td class="facility-td"><b>Tentage (Amt):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_tentage) }}</td>
              </tr>
              <tr>
                <td class="facility-td"><b>Electricity (Amt):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_electricity) }}</td>
                <td class="facility-td"><b>Catering (%):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_catering) }}</td>
              </tr>
              <!--<tr>
                <td width="150px" class="facility-td"><b>CGST (%):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_servicetax) }}</td>
                <td width="150px" class="facility-td"><b>SGST (%):</b></td>
                <td class="facility-td">{{ slash_decimal($facility[0]->rebate_vat) }}</td>
              </tr>-->
            </tbody>
          </table>
      </div>
	  <div class="table-responsive">
          <table class="table mb30">
            <thead>
              <tr>
                <th class="facility-th" colspan="6">Booking Rate</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left-align"><b>Member Type</b></td>
                <td class="left-align"><b>Booking Rate</b></td>
                <td class="left-align"><b>Electricity/Generator Charges</b></td>
                <td class="left-align"><b>AC Charges</b></td>
                <td class="left-align"><b>Safai &amp; General</b></td>
                <td class="left-align"><b>Security Charges</b></td>
              </tr>
              <?php if(count($booking_rate)>0){?>
              @foreach ($booking_rate as $value)
              <tr>
                <td class="left-align">{{ $value->member_type }}</td>
                <td class="left-align">{{ slash_decimal($value->booking_rate) }}</td>
                <td class="left-align">{{ slash_decimal($value->generator_charges) }}</td>
                <td class="left-align">{{ slash_decimal($value->ac_charges) }}</td>
                <td class="left-align">{{ slash_decimal($value->safai_general) }}</td>
                <td class="left-align">{{ slash_decimal($value->security_charges) }}</td>
              </tr>
              @endforeach
              <?php } else{?>
              <tr>
                <td colspan="5">No results found!</td>
              </tr>
              <?php }?>
            </tbody>
          </table>
      </div>
	</div>
</div>
</div>
@endsection