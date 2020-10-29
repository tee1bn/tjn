<?php
$page_title = "Partners Packages";
include 'includes/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>
                <h3 class="content-header-title mb-0">Sales partners support packages</h3>
            </div>
        </div>
        <div class="content-body">

            <div class="row grouped-multiple-statistics-card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                    <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon primary d-flex justify-content-center mr-3">
                                            <div class="b-box">
                                                <span class="d-box">
                                                    <?= $total['basic']; ?>
                                                </span>
                                            </div>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">Basic</h3>
                                            <p class="sub-heading">Package</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                    <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon danger d-flex justify-content-center mr-3">
                                            <div class="b-box">
                                                <span class="d-box">
                                                    <?= $total['advanced']; ?>
                                                </span>
                                            </div>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">Advanced</h3>
                                            <small>Package</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                    <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                        <span class="card-icon success d-flex justify-content-center mr-3">
                                            <div class="b-box">
                                                <span class="d-box">
                                                    <?= $total['professional']; ?>
                                                </span>
                                            </div>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">Professional</h3>
                                            <small>Package</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                                    <div class="d-flex align-items-start">
                                        <span class="card-icon warning d-flex justify-content-center mr-3">
                                            <div class="b-box">
                                                <span class="d-box">
                                                    <?= $total_sales_partner; ?>
                                                </span>
                                            </div>
                                        </span>
                                        <div class="stats-amount mr-3">
                                            <h3 class="heading-text text-bold-600">Sales partner</h3>
                                            <small>Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">


                <div class=" col-md-12">
                    <div class="card" style="">
                        <div class="card-content">
                            <div class="card-body">
                                <?php include_once 'template/default/composed/filters/team.php';?>

                                <h4 class="card-tile border-0" style="position: absolute;right: 35px;top: 20px;">
                                    <small class="float-right">
                                        <?=$note;?>

                                    </small>

                                </h4>
                                <hr>
                                <div class="row table-responsive">

                                    <table class="table">
                                        <tr>
                                            <td></td>
                                            <td>Sales partner ID</td>
                                            <td>Name</td>
                                            <td>Level</td>
                                            <td>Package</td>
                                            <td>First order</td>
                                            <td>Status</td>
                                            <!-- <td>Bill</td> -->
                                        </tr>
                                        <tbody>
                                        <?php $i = 1;
                                        foreach ($all_downlines as $downline):
                                            $contact = $downline->getContact($auth->mlm_id);
                                            $package = $downline->subscription;

                                            ?>

                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $downline->id; ?></td>
                                                <td><?= $contact['fullname']; ?></td>
                                                <td><?= $downline->determine_level($auth->placement_position, 'placement'); ?></td>
                                                <td><?= $package->payment_plan->package_type; ?></td>
                                                <td><?= (isset($package->paid_at)) ? date('d/m/Y', strtotime($package->paid_at)) : 'Nil'; ?></td>
                                                <td><?=$downline->MembershipStatusDisplay['fa2'] ?? "<i class='ft-x text-danger'></i>";?></td>
<!--                                                 <td>
                                                    <?=$contact['invoice'];?>
                                                </td>
 -->                                            </tr>
                                            <?php $i++; endforeach; ?>

                                        </tbody>
                                    </table>


                                </div>

                            </div>
                        </div>
                    </div>

                    <ul class="pagination">
                        <?= $this->pagination_links($data, $per_page);?>
                    </ul>
                </div>



            </div>


            <div>
                <small> * * * Due to data protection regulations only contacts data or names can be viewed by direct
                    distributors. Exception: distributors have released what their contact details for the upline.
                </small>
            </div>


        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>

