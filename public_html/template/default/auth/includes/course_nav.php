<style type="text/css">

    .course-nav a:hover {

        background: #00adb0;
    }
</style>


<?php
$return = $_GET['url'];

$person =  explode("/", MIS::current_url())[0];

if ($person == 'admin') {

  $base = "$domain/admin";
  $action = explode('/', $_GET['url'])[3];
}else{

  $action = explode('/', $_GET['url'])[2];
  $base = $domain;
}

;?>
<div class="col-xl-2 col-md-2 col-12" style="padding: 0px;">
    <div class="card">
        <div class="card-heading">
            <!-- <h3 class="card-subtitle text-muted"><b>Plan your Course</b></h3> -->
        </div>
        <ul class="list-group list-group-flush course-nav">
            <a class="list-group-item">

                <h5 class=" text-muted"><b>Plan Course</b> <?= $course->ApprovalStatus; ?></h5>
            </a>

            <a href="<?= $base; ?>/courses/<?= $course->id; ?>/goal" class="list-group-item
           <?= ($action == 'goal') ? 'active' : ''; ?>">

                Target Student
            </a>

            <a href="<?= $base; ?>/courses/<?= $course->id; ?>/curriculum" class="list-group-item
                        <?= ($action == 'curriculum') ? 'active' : ''; ?>">

                Create Course Content
            </a>

            <a href="<?= $base; ?>/courses/<?= $course->id; ?>/publish" class="list-group-item
                       <?= ($action == 'publish') ? 'active' : ''; ?>">

                Publish Your Course
            </a>

        </ul>
    </div>

    <a onclick="$confirm_dialog = new ConfirmationDialog('<?= domain; ?>/shop/submit_for_review/<?= $course->id; ?>/?return=<?= $_GET['url']; ?>')"
       href="javascript:void(0);">
        <button class="btn-icon btn btn-secondary btn-round" type="button">
            Submit For Review
            <i class="fa fa-check-circle"></i>
        </button>
    </a><br>
</div>