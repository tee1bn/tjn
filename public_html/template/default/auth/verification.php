<?php
$page_title = "Verification";
 include 'includes/header.php';

    $financial_banks = v2\Models\FinancialBank::all();


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content" >
              <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                      <h3 class="content-header-title mb-0"> Verifications <?=$auth->VerifiedBagde;?></h3>
                    </div>
                   <div class="content-header-right text-md-right col-md-6">
                      
                    </div>
                  </div>
                  <div class="content-body">


                    <div class="col-md-12">
                      <div class="alert alert-dark">
                        <strong>Why?</strong> <small>When you verify your Identity, you are able to fully enjoy all of our services. Otherwise, there will be limits to processing a deposit or withdrawal with us.</small>
                      </div>
                      <?php foreach (v2\Models\UserDocument::$document_types as $key => $type) :?>
                        <div class=" card">
                            <div class="card-header">
                              <h4 class="card-title" style="display: inline;">
                                <a data-toggle="collapse" title="click to see uploaded documents" href="#collapse1<?=$key;?>"><i class="ft-caret"></i> <?=$type['name'];?></a>
                                  </h4>
                                    <small>* <?=$type['instruction'];?></small>
                                <form class="ajax_for float-right" method="post"  action="<?=domain;?>/user_doc_crud/upload_document" 
                                  enctype="multipart/form-data">
                                  <input style="display:none; " type="file" name="document" onchange="form.submit();">
                                  <?php 
                                    $document = $auth->documents->where('document_type', $key)->first();
                                  if ((($document != null) && (! $document->is_status(2))) || ($document == null) ):?>
                                    <button class="btn btn-dark btn-sm" type="button" onclick="form.document.click();">+ Upload</button> 
                                  <?php endif;?>
                                  <input type="hidden" name="type" value="<?=$key;?>">
                                </form>                                

                            </div>
                            <div id="collapse1<?=$key;?>" class=" collapse show" >
                              <div class="card-body">
                                <ul class="list-group list-group-flush">
                                  <?php $i=1; foreach ($auth->documents->where('document_type', $key) as $key => $doc) :?>

                                  <!-- The Modal -->
                                  <div class="modal" id="myModal<?=$doc->id;?>">
                                    <div class="modal-dialog modal-lg" style="z-index: 999;">
                                      <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                          <h4 class="modal-title"><?=$type['name'];?> <?=$doc->DisplayStatus;?></h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                     <div class="modal-body">
                                       <img id="simage" src="<?=domain;?>/<?=$doc->path;?>" style="width: 100%;">

                                     </div>




                                      </div>
                                    </div>
                                  </div>





                                    <li class="list-group-item"><?=$i;?>) <?=$doc->DisplayStatus;?>  
                                      <button type="button" class="btn btn-sm btn-dark float-right" data-toggle="modal" data-target="#myModal<?=$doc->id;?>">
                                    Open 
                                  </button>
                                    </li>
                                  <?php break; $i++; endforeach ;?>
                                </ul>
                                  
                              </div>
                            </div>
                        </div>
                      <?php endforeach ;?>

                                                    

                      </div>

             
                  </div>
                </div>
              </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
