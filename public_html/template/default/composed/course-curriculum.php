<div class="content-body">
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 ">
                    <h3 class="content-header-title mb-0">Course Curriculum</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= domain; ?>">
                                        Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Users</a>
                                </li>
                                <li class="breadcrumb-item active">Course Curriculum
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <style>
                    .course-structure-titles {
                        font-weight: bold;
                        margin-top: 40px;
                    }

                    .lecture {
                        margin-bottom: 0px;

                    }

                    .course-section {
                        padding-bottom: 4px;
                        padding-top: 4px;
                    }
                </style>


                <script>
                    $COURSE_ID = <?=$course->id;?>;
                </script>
                <script src="<?= general_asset; ?>/js/angulars/course_curriculum.js"></script>
                <section id="user-profile-cards" class="row mt-2" ng-controller="CourseCurriculumController">

                    <?php $this->view('auth/includes/course_nav', compact('course')); ?>

                    <div class="col-xl-10 col-md-10 col-12" style="padding: 0px;">
                        <div class="card card border-teal border-lighten-2">

                            <div class="card-body" id="course-curriculum">
                                <div class="card-text">
                                    <h4>Course Curriculum</h4>
                                    <p>Start putting together your course by creating sections, lectures below.</p>
                                </div>
                                <br>

                                <form method="post" class="ajax_form"
                                      action="<?= domain; ?>/courses/add_course_curriculum"
                                      enctype="multipart/form-data">


                                    <div ng-cloak
                                         ng-repeat=" ($section_index , $section) in $curriculum.$sections"
                                         class="card box-shadow-0 border-primary ">
                                        <div class="card-header card-head-inverse bg-primary">
                                            <h4 class="card-title">Section {{$section_index+1}}:
                                                <i class="fa fa-file-o"></i>
                                                <small contenteditable="true" ng-model="$section.$title">
                                                    {{$section.$title}}
                                                </small>
                                            </h4>

                                            <a class="heading-elements-toggle"><i
                                                        class="fa fa-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="">
                                                            <button type="button" ng-click="$section.add_lecture()"
                                                                    class="btn btn-secondary btn-sm">
                                                                +Add Lecture
                                                            </button>
                                                        </a></li>
                                                    <li><a data-toggle="collapse" href="#section{{$section_index}}"><i
                                                                    class="ft-minus"></i></a></li>
                                                    <li><a ng-click="$curriculum.remove_section($section_index)"><i
                                                                    class="fa fa-trash"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show" id="section{{$section_index}}">
                                            <div ng-repeat="($lecture_index, $lecture) in $section.$lectures"
                                                 class="card-body course-section">
                                                <!-- <p class="card-text">Use <code>border-primary</code> class for primary border color.</p> -->


                                                <div class="card box-shadow-0 border-primary lecture">
                                                    <div class="card-header">
                                                        <h4 class="card-title">
                                                            <i class="fa fa-check-circle text-primary"></i> Lecture
                                                            {{$index+1}}:
                                                            <small contenteditable="true"
                                                                   ng-model="$lecture.$data.$title">{{$lecture.$title}}
                                                            </small>
                                                        </h4>
                                                        <a class="heading-elements-toggle"><i
                                                                    class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <!-- <li><a data-toggle="collapse" href="#section{{$section_index}}lecture{{$lecture_index}}"><button class="btn btn-primary btn-sm">+Add Content</button>
                                                                </a>
                                                              </li> -->
                                                                <li><a data-toggle="collapse"
                                                                       href="#section{{$section_index}}lecture{{$lecture_index}}"><i
                                                                                class="ft-plus"></i></a></li>

                                                                <li>
                                                                    <a ng-click="$section.remove_lecture($lecture_index)"><i
                                                                                class="fa fa-trash"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>


                                                    <div class="card-content collapse"
                                                         id="section{{$section_index}}lecture{{$lecture_index}}"
                                                         style="">
                                                        <div class="card-body row">
                                                            <p class="col-md-12">
                                                                <textarea rows="6" ck-editor
                                                                          ng-model="$lecture.$data.textcontent"
                                                                          class="form-control"></textarea>


                                                            </p>

                                                        </div>


                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="pull-left">Quiz</label>
                                                        <select class="form-control" ng-model="$lecture.$data.quiz_id">
                                                            <option value="">Select to Add a Quiz</option>
                                                            <option value="{{$quiz.id}}"
                                                                    ng-selected="$lecture.$data.quiz_id==$quiz.id"
                                                                    ng-repeat="($index, $quiz) in $quizes">
                                                                {{$quiz.title}}
                                                            </option>

                                                        </select>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <input type="hidden" name="course_id" value="<?= $course->id; ?>">
                            <textarea style="display:none;" rows="6" name="curriculum">{{$curriculum}}</textarea>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" ng-click="$curriculum.add_section()">+Add
                                    Section
                                </button>
                                <button type="submit" class="btn btn-secondary">Save</button>
                            </div>

                            </form>


                        </div>

                    </div>
            </div>

            </section>
            <!--/ User Profile Cards -->


        </div>
    </div>
</div>
