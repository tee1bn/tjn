                    
                    <table id="trading_account" class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>#Sn</th>
                          <th>Account/Broker</th>
                          <th>Total Deposits</th>
                          <th>Total Withdrawals</th>
                          <th>Date/Status</th>
                          <th>LPR Status</th>
                        </tr>
                      </thead>                    

                       <?php  $i=1; foreach ($user->trading_accounts as $account) :
                        $withdrawals = $account->total_withdrawals();
                        $deposits = $account->total_deposits();
                        ?>
                        <tr>
                          <td><?=$i;?></td>
                          <td>
                            <?=$account->account_number;?><br>
                            <?=$account->broker->name;?>
                          </td>
                          <td>
                            $<?=MIS::money_format($deposits['dollar']);?><br>
                            <?=$currency;?><?=MIS::money_format($deposits['naira']);?><br>
                          </td>
                          <td>
                            $<?=MIS::money_format($withdrawals['dollar']);?><br>
                            <?=$currency;?><?=MIS::money_format($withdrawals['naira']);?><br>
                          </td>
                          <td><span class="badge badge-secondary"><?=$account->created_at->format('M j, Y H:i:A');?></span>
                            <br/><?=$account->DisplayActiveStatus;?></td>
                          
                          <td>
                           <?=$account->DisplayLPRStatus;?>
                          </td>
                        </tr>
                    
                        <?php $i++; endforeach ; ?>
                           
                    
                          </tbody>
                    </table>                               


<script>
    $(function() {
        $('#trading_account').DataTable();
    });
</script>