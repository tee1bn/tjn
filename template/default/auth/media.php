<?php
$page_title = "Media";
include 'includes/header.php'; ?>
<?php


; ?>


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>

                <h3 class="content-header-title mb-0">Media</h3>
            </div>

            <!--  <div class="content-header-right col-md-6 col-12">
               <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                 <div class="btn-group" role="group">
                   <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                   <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
                 </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
               </div>
             </div> -->
        </div>
        <div class="content-body">

            <style>
                iframe {
                    width: 100% !important;
                    height: 400px !important;
                }
            </style>

            <div class="row match-height">

                <div class="col-md-8">
                    <div class="card" style="">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <?= CMS::fetch('media_embed'); ?>


                                    </div>
                                    <div class="col-md-10">
                                        <p></p>
                                        Basic workshop for partners
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-md-4">
                    <div class="card" style="">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-tile border-0">Content of this lesson </h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <?= CMS::fetch('media_content_of_lesson'); ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <?php foreach ($documents as $category => $items) : ?>


                    <div class=" col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3 text-center">Type/Size</div>
                                        <div class="col-9 text-center"><?= (strlen(trim($category)) > 0) ? $category : 'Others'; ?>
                                            <span class="badge badge-secondary float-right"><?= count($items); ?></span>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">

                                        <div class="col-md-12" style="max-height: 200px!important;overflow-y: scroll;">


                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($items as $item) :
                                                    ?>

                                                    <li class="list-group-item small-padding">

                                                        <div class="row">

                                                            <div class="col-3 text-center">
                                                                <a href="<?= domain; ?>/<?= $item['path']; ?>"
                                                                   target="_blank">
                                                                    .<?= pathinfo($item['path'], PATHINFO_EXTENSION); ?>/<?=MIS::formatSizeUnits(filesize($item['path']));?>
                                                                </a>

                                                            </div>
                                                            <div class="col-9 text-center">
                                                                <a href="<?= domain; ?>/<?= $item['path']; ?>"
                                                                   target="_blank">
                                                                    <?= $item['filename']; ?>
                                                                </a>
                                                            </div>


                                                        </div>


                                                    </li>
                                                <?php endforeach; ?>


                                            </ul>

                                        </div>

                                        <!--     <div class="col-md-12 text-center">
                                                 Show more
                                             </div>-->

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>


            </div>


        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>

