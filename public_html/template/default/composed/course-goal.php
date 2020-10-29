<div class="content-body">


    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 ">
                    <h3 class="content-header-title mb-0">Course Target</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= domain; ?>">
                                        Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Users</a>
                                </li>
                                <li class="breadcrumb-item active">Course Target
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">


                <script>
                    $COURSE_ID = <?=$course->id;?>;
                </script>
                <script src="<?= general_asset; ?>/js/angulars/course_target.js"></script>
                <!-- User Profile Cards -->
                <section id="user-profile-cards" class="row mt-2" ng-controller="CourseTargetController">

                    <?php $this->view('auth/includes/course_nav', compact('course')); ?>

                    <div class="col-xl-9 col-md-9 col-12">
                        <div class="card card border-teal border-lighten-2">
                            <div class="text-center">

                                <div class="card-body">
                                    <div class="card-text">
                                        <h4>Target Student</h4>
                                        <p>You're on your way to creating a course! The descriptions you write here will
                                            help students decide if your course is the one for them.</p>
                                    </div>
                                    <br>
                                    <style>
                                        .target-input {
                                            margin-bottom: 15px;
                                        }
                                    </style>

                                    <form ng-cloak class="ajax_form" method="post"
                                          action="<?= domain; ?>/courses/update/<?= $course->id; ?>">
                                        <?= $this->inputErrors(); ?>
                                        <input type="hidden" name="course_id" value="<?= $course->id; ?>">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <small class="pull-left">What knowledge & tools are required?</small>

                                                <div ng-repeat="$requirement in  $course_target.$requirements track by $index "
                                                     class="input-group target-input">
                                                    <input required="" type="text" class="form-control"
                                                           name="requirements[]"
                                                           placeholder="Example: Be able to read financial statements. A laptop is optional."
                                                           aria-describedby="button-addon4" value="{{$requirement}}">
                                                    <div class="input-group-append" id="button-addon4">
                                                        <button class="btn btn-danger"
                                                                ng-click="$course_target.delete_requirement($index)"
                                                                type="button"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>


                                                <a class="badge badge-primary text-white pull-left"
                                                   ng-click="$course_target.new_requirement()">+ Add Answer</a>
                                            </div>
                                            <br>
                                            <br>


                                            <div class="form-group">
                                                <small class="pull-left">Who should take this course?</small>

                                                <div ng-repeat=" $target_student in  $course_target.$target_students track by $index"
                                                     class="input-group target-input">
                                                    <input required="" type="text" class="form-control"
                                                           name="target_students[]"
                                                           placeholder="Example: Beginner Accountants curious about data science. This course is not for experienced data scientists."
                                                           aria-describedby="button-addon4" value="{{$target_student}}">
                                                    <div class="input-group-append" id="button-addon4">
                                                        <button class="btn btn-danger"
                                                                ng-click="$course_target.delete_target_student($index)"
                                                                type="button"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>


                                                <a class="badge badge-primary text-white pull-left"
                                                   ng-click="$course_target.new_target_student()">+ Add Answer</a>
                                            </div>
                                            <br>
                                            <br>

                                            <div class="form-group">
                                                <small class="pull-left">What will students achieve or be able to do
                                                    after taking your course?
                                                </small>

                                                <div ng-repeat="$aim in  $course_target.$aims track by $index"
                                                     class="input-group target-input">
                                                    <input required="" type="text" class="form-control"
                                                           name="aims[]"
                                                           placeholder="Example: Take great confidence in analysing financial statements."
                                                           aria-describedby="button-addon4" value="{{$aim}}">
                                                    <div class="input-group-append" id="button-addon4">
                                                        <button class="btn btn-danger"
                                                                ng-click="$course_target.delete_aim($index)"
                                                                type="button"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>


                                                <a class="badge badge-primary text-white pull-left"
                                                   ng-click="$course_target.new_aim()">+ Add Answer</a>
                                            </div>
                                            <br>
                                            <br>

                                            <div class="row">

                                                <div class="form-group col-md-6">
                                                    <label class="pull-left">Next Course</label>
                                                    <select class="form-control" name="next_course">
                                                        <option>Select Next Course</option>
                                                        <?php
                                                        foreach (v2\Models\Market::OnSale()->GetCategory('course')->get()->where('item_id', '!=', $course->id) as $key => $other_course) :?>
                                                            <option
                                                                <?= ($course->GoalJson['next_course'] == $other_course->good()->id) ? 'selected' : ''; ?>
                                                                    value="<?= $other_course->good()->id; ?>">

                                                                <?= $other_course->good()->title; ?>
                                                                -<?= $other_course->good()->price; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>


                                            </div>

                                        </div>

                                        <div class="form-actions center">
                                            <!--   <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                              </button> -->
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check-square-o"></i> Save
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                </section>
                <!--/ User Profile Cards -->


            </div>
        </div>
    </div>

