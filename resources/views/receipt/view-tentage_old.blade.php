<div class="table-responsive">
  <table class="table mb30">
    <thead>
      <tr>
        <th class="facility-th" colspan="3">Particular Details</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="width: 100px" class="left-align"><b>S.No</b></td>
        <td style="min-width: 100px" class="left-align"><b>Particular</b></td>
        <td style="min-width: 100px" class="left-align"><b>Amount</b></td>
      </tr>
      <?php $i = 0; $total = 0; ?>
      @if($receipt[0]->est_cof >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Estimated cost of the food</td>
        <td class="left-align">{{$receipt[0]->est_cof}}</td>
        <?php $total = $total+$receipt[0]->est_cof; ?>
      </tr>
      @endif
      @if($receipt[0]->vat_supplier >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">SGST to be charged by the supplier</td>
        <td class="left-align">{{$receipt[0]->vat_supplier}}</td>
        <?php $total = $total+$receipt[0]->vat_supplier; ?>
      </tr>
      @endif
      @if($receipt[0]->est_catering >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Estimated amount for catering service</td>
        <td class="left-align">{{$receipt[0]->est_catering}}</td>
        <?php $total = $total+$receipt[0]->est_catering; ?>
      </tr>
      @endif
      @if($receipt[0]->vat_caterer >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">SGST to be charged by the caterer</td>
        <td class="left-align">{{$receipt[0]->vat_caterer}}</td>
        <?php $total = $total+$receipt[0]->vat_caterer; ?>
      </tr>
      @endif
      @if($receipt[0]->st_caterer >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">CGST to be charged by the caterer</td>
        <td class="left-align">{{$receipt[0]->st_caterer}}</td>
        <?php $total = $total+$receipt[0]->st_caterer; ?>
      </tr>
      @endif
      @if($receipt[0]->est_tentage >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Estimated cost of Tentage</td>
        <td class="left-align">{{$receipt[0]->est_tentage}}</td>
        <?php $total = $total+$receipt[0]->est_tentage; ?>
      </tr>
      @endif
      @if($receipt[0]->vat_tent >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">SGST to be charged by Tent Supplier</td>
        <td class="left-align">{{$receipt[0]->vat_tent}}</td>
        <?php $total = $total+$receipt[0]->vat_tent; ?>
      </tr>
      @endif
      @if($receipt[0]->st_tent >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">CGST to be charged by Tent Supplier</td>
        <td class="left-align">{{$receipt[0]->st_tent}}</td>
        <?php $total = $total+$receipt[0]->st_tent; ?>
      </tr>
      @endif
      @if($receipt[0]->security_deposit >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Security Deposit</td>
        <td class="left-align">{{$receipt[0]->security_deposit}}</td>
        <?php $total = $total+$receipt[0]->security_deposit; ?>
      </tr>
      @endif
      @if($receipt[0]->corpus_fund >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Corpus Fund</td>
        <td class="left-align">{{$receipt[0]->corpus_fund}}</td>
        <?php $total = $total+$receipt[0]->corpus_fund; ?>
      </tr>
      @endif
      @if($receipt[0]->others >0)
      <tr>
        <td class="left-align"><?php echo $i = $i+1; ?></td>
        <td class="left-align">Misc/Others</td>
        <td class="left-align">{{$receipt[0]->others}}</td>
        <?php $total = $total+$receipt[0]->others; ?>
      </tr>
      @endif
      <tr>
      	<td colspan="2" class="left-align" style="color:red">Note: Return Cheque Penalty, Insufficient Fund - Rs. 500 /- , Other Reason - Rs. 250/-</td>
        <td class="left-align total">Total: <b>{{round($total)}}</b></td>
      </tr>
    </tbody>
  </table>
</div>