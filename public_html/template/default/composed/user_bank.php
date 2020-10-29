  <table id="payment-histor" class="table table-striped table-bordered zero-configuration" >
      <tbody>

        <?php foreach ($user->banks->sortByDesc('created_at') as $key => $bank):?>

        <tr>
          <td style="padding: 2px;">
            <div class="col-xl-12 col-lg-12" style="padding: 0px;">
              <div class="alert bg-dark  alert-dismissible mb-2" role="alert">
                <strong class="float-right"><?=$bank->AccountHolder;?></strong><br>
                <strong><?=$bank->financial_bank->bank_name;?></strong>
                 <br>
                <?=$bank->account_number;?>
                <span class="float-right"><?=$bank->DisplayStatus;?></span>
              </div>
            </div>

          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    
  </table>
