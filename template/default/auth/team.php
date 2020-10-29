<?php
$upline = User::where('mlm_id', $user->referred_by)->first();
$page_title = "Overview Team";
include 'includes/header.php'; ?>


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>

                <h3 class="content-header-title mb-0">Overview of my Team</h3>
            </div>

        </div>

        <style>
            .team-leader {

                height: 100px;
                border-radius: 46px;
                width: 100px;
                object-fit: cover;
            }
        </style>


        <div class="content-body">
            <?php require_once 'template/default/auth/includes/team_page.php'; ?>

            <div class="row">

                <div class="col-md-4">

                    <div class="dropdown">
                        <button class="btn btn-dark btn-block  dropdown-toggle" type="button" data-toggle="dropdown">
                            Lifeline Level <span class="badge badge-secondary"> <?= $level_of_referral; ?> </span>
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= domain; ?>/genealogy/team/<?= $user->username; ?>/<?= $i; ?>">
                                        Level <?= $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>


                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body"
                                 style="padding: 7px !important;padding-bottom: 5px!important;padding-top: 10px!important;">
                                <form class="ajax_form" action="<?= domain; ?>/user-profile/set_contact_availability"
                                      method="post" style="margin: 0px;">
                                    <label>
                                        <input type="checkbox" onchange="$('#submit_btn').click();"
                                               name="contact_availability"
                                               value="1"
                                            <?= ((isset($auth->SettingsArray['contact_availability'])) &&
                                            ($auth->SettingsArray['contact_availability'] == 1) ? 'checked' : ''); ?>
                                               style="height: 20px;width: 20px;position: absolute;top: 11px;">
                                        <span style="margin-left: 20px;">share my personal information (name, email, phone) for the entire Upline</span>
                                    </label>
                                    <button id="submit_btn" type="submit" style="display: none"></button>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>



                <style>

                    td {
                        padding-right: 1px !important;
                        padding-left: 1px !important;
                        text-align: center;
                    }
                </style>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body ">
                                <?php
                                $sieve = $list['sieve'];
                                include_once 'template/default/composed/filters/team.php'; ?>

                                <h4 class="card-tile border-0" style="position: absolute;right: 35px;top: 20px;">
                                    <small class="float-right">
                                        <?= $note; ?>

                                    </small>

                                </h4>
                                <hr>

                                <div class="row table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td style="width: 5%;">Sn</td>
                                            <td>Partner ID</td>
                                            <td>Name</td>
                                            <td>Level</td>
                                            <td>E-mail</td>
                                            <td>Phone</td>
                                            <td>Registered</td>
                                            <td>Package</td>
                                            <td>Direct <br>sales partner</td>
                                            <td>Own <br>Merchants</td>
                                            <td>Status</td>
                                        </tr>
                                        <tbody>
                                        <?php $i = 1;
                                        $status_count = [];
                                        foreach ($list['list'] as $key => $downline):
                                            $contact = $downline->getContact($user->mlm_id);
                                            $status = $downline->MembershipStatusDisplay;
                                            $status_count[] = $status['value'];
                                            $direct_sales_partner_count[] = $status['value'];
                                            ?>


                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $downline->id; ?></td>
                                                <td><?= $contact['fullname']; ?></td>
                                                <td><?= $level_of_referral; ?></td>
                                                <td><?= $contact['email']; ?></td>
                                                <td><?= $contact['phone']; ?></td>

                                                <td><?= date("d/m/Y", strtotime($downline->created_at)); ?></td>
                                                <td><?= $downline->subscription->payment_plan['package_type']; ?></td>
                                                <td><?= $no[$downline->mlm_id]['no_of_direct_lines'] ?? 0; ?></td>
                                                <td><?=$own_merchant_count[] = $response[$downline['id']]['tenantCount'] ?? 0;?></td>
                                                <td><?= $status['display']; ?></td>
                                            </tr>
                                            <?php $i++; endforeach; ?>

                                        <tr>
                                            <td></td>
                                            <td colspan="7"><b>Total</b></td>
                                            <td><?= $no->sum('no_of_direct_lines'); ?></td>
                                            <td><?=array_sum($own_merchant_count ?? []) ;?></td>
                                            <td><?= count($status_count); ?>/<?= (collect($status_count)->countBy()->toArray()[1] ?? 0); ?></td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <ul class="pagination">
                        <?= $this->pagination_links($list['data'], $per_page);?>
                    </ul>
                </div>

                <div class="col-md-12">

                    <small class="text-muted">* * * Due to data protection regulations only contacts data may be viewed
                        by direct distributors. Exception: Distributors have shared that their contact information for
                        the upline
                    </small>

                </div>


            </div>


        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>
