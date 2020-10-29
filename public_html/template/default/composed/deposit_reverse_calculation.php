

<table class="table table-striped table-sm">

  <tr>
    <th style='padding: 5px;'>Amount Confirmed</th>
    <td class='text-right' style='padding: 5px;'><?=$currency;?><?=MIS::money_format($reverse_calculation['amount_confirmed']);?></td>  
  </tr>

  <tr>
    <th style='padding: 5px;'>Gateway Fee (<?=$reverse_calculation['gateway'];?>)</th>
    <td class='text-right' style='padding: 5px;'><?=$currency;?><?=MIS::money_format($reverse_calculation['gateway_fee']);?></td>  
  </tr>

  <tr>
    <th style='padding: 5px;'>Stamp duty</th>
    <td class='text-right' style='padding: 5px;'><?=$currency;?><?=MIS::money_format($reverse_calculation['stamp_duty']['stamp_duty']);?></td>  
  </tr>

  <tr>
    <th style='padding: 5px;'>Service Charge(<?=$reverse_calculation['service_fee_percent'];?>%)</th>
    <td class='text-right' style='padding: 5px;'><?=$currency;?><?=MIS::money_format($reverse_calculation['service_charge']);?></td>  
  </tr>

  <tr>
    <th style='padding: 5px;'>VAT (<?=$reverse_calculation['vat']['percent'];?>%)</th>
    <td class='text-right' style='padding: 5px;'><?=$currency;?><?=MIS::money_format($reverse_calculation['vat']['value']);?></td>  
  </tr>

  <tr>
    <th style='padding: 5px;'>Order Value</th>
    <td class='text-right' style='padding: 5px;'>$<?=MIS::money_format($reverse_calculation['dollar_value']);?></td>  
  </tr>


</table>

