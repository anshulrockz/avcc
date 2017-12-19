<div class="table-responsive">
  <table class="table mb30">
    <thead>
      <tr>
        <th class="facility-th" colspan="3">Particular Details</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="min-width: 100px" class="left-align"><b>S.No</b></td>
        <td style="min-width: 100px" class="left-align"><b>Particular</b></td>
        <td style="min-width: 100px" class="left-align"><b>Amount</b></td>
      </tr>
      <tr>
        <td class="left-align">1</td>
        <td class="left-align">CGST</td>
        <td class="left-align">{{number_format((float)$servicetax_total+$receipt[0]->others_amount*$global_st/100, 2, '.', '')}}</td>
      </tr>
      <tr>
        <td class="left-align">2</td>
        <td class="left-align">SGST</td>
        <td class="left-align">{{number_format((float)$vat_total+$receipt[0]->others_amount*$global_vat/100, 2, '.', '')}}</td>
      </tr>
      <tr>
      	<td class="left-align" style="color:red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</td>
        <td class="right-align">Total:</td>
        <?php
		$others_tax = $receipt[0]->others_amount*$global_st/100+$receipt[0]->others_amount*$global_vat/100;
		$tax = $servicetax_total+$vat_total;
		
		$total = $tax+$others_tax;
		?>
        <td class="left-align total"><b>{{round($total)}}</b></td>
      </tr>
    </tbody>
  </table>
</div>