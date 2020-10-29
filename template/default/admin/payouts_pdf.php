<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 -->
<style>
        table tbody tr:nth-child(even){ 
        background: lightgray !important;
    }

    table tbody tr td , table thead tr td { 
        padding: 5px;

    }

    table tbody tr , table thead tr { 
        line-height: 15px;
    }

    
    table thead td {
     background-color: #88b988a6;
    text-align: center;
}
    </style>                          



<div class="<?=$container;?>">
    <div class="row">
        <div class="col-md-12">
            <div class="invoice-title">
                <h4>Payouts</h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <address>
                        Company: <?=project_name;?><br>
                        Month: <?=date("F Y", strtotime($month));?><br>
                        <!-- Status: <?=@$status;?><br> -->
                    </address>
                </div>
                <div class="text-right">
                    <address>
                        <strong>Generated Date:</strong><br>
                        <?=date("M d, Y");?><br><br>                      
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                 <!--    <address>
                        <strong>Generated Date:</strong><br>
                        <?=date("M d, Y");?><br><br>
                    </address> -->
                </div>
                <div class="col-md-6 text-right">
<!--                     <address>
                        <strong>Generated Date:</strong><br>
                        March 7, 2014<br><br>
                    </address>
 -->                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!-- <h3 class="panel-title"><strong>Summary</strong></h3> -->
                </div>
                <div class="panel-body">
                    <div class="table-responsie">
                        <table class="table table-condensed" width="100%">
                            <thead>
                                <tr>
                                    <td class="text-left"><strong>S/N</strong></td>
                                    <td class="text-left"> <strong>User</strong></td>
                                    <td class="text-left"><strong>IBAN</strong></td>
                                    <td class="text-right"><strong>Amount(<?=$currency;?>)</strong></td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i=1; foreach ($payouts as $key => $payout) :
                                    $user = $users[$key];
                                ?>
                                    <tr>
                                        <td class="text-left"><?=$i++;?></td>
                                        <td class="text-left"><?=$user->fullname;?></td>
                                        <td class="text-left"><?=$user->company->iban_number;?></td>
                                        <td class="text-right"><?=$this->money_format($payout['amount']);?></td>
                                    </tr>
                                <?php endforeach  ;?>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-right"> Total</td>
                                    <td class="no-line text-right">
                                        <?=$currency;?><?=$this->money_format($total);?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>