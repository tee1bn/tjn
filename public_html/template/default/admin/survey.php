<?php
$page_title = "Survey";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0" style="display: inline;">Survey</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-secondary  float-right" href="<?=Questionaire::createLink();?>">+ Survey</a>
            </div>
          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

               <?php //include_once 'template/default/composed/filters/survey_filter.php';?>
              <h4 class="card-title" style="display: inline;"></h4>


              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
             <div class="card-content">
              <div class="card-body">



                <table class="table table-striped" id="surveys">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>*</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach (Questionaire::all() as $key => $questionaire) :?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$questionaire->title;?></td>
                            <td><?=$questionaire->publishedStatus;?></td>
                            <td>
                                <div class="dropdown">
                                  <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                  <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="<?=$questionaire->editLink;?>">Edit</a>
                                    <a class="dropdown-item" href="<?=$questionaire->PreviewLink;?>">Preview</a>
                                    <a class="dropdown-item" href="<?=$questionaire->viewResponses;?>">Stats</a>
                                    <a class="dropdown-item" href="<?=$questionaire->viewResponsesTable;?>">Responses</a>
                                        
                                    <a class="dropdown-item" onclick='$confirm_dialog = new ConfirmationDialog("<?=$questionaire->deleteLink;?>")'
                                     href="javascript:void(0);">Delete</a>
                                    <!-- <li><a href="#">JavaScript</a></li> -->
                                  </ul>
                                </div>
                                
                            </td>
                        </tr>
                        <?php endforeach ;?>

                        <?php if (Questionaire::all()->count() == 0):?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    There is no result to display.
                                </td>
                            </tr>
                        <?php endif ;?>
                    </tbody>
                </table>




                
              </div>
            </div>
          </section>

          <ul class="pagination">
              <?php //echo $this->pagination_links($data, $per_page);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
