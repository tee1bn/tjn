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

                    <div class="content-wrapper">
                  <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                      <h3 class="content-header-title mb-0">Verifications <?=$auth->VerifiedBagde;?></h3>
                    </div>
                   <div class="content-header-right text-md-right col-md-6">
                      
                    </div>
                  </div>
                  <div class="content-body">

                    <div class="col-md-12">
                      <?php foreach (v2\Models\UserDocument::$document_types as $key => $type) :?>
                        <div class=" card">
                            <div class="card-header">
                              <h4 class="card-title" style="display: inline;">
                                <a data-toggle="collapse" title="click to see uploaded documents" href="#collapse1<?=$key;?>"><i class="ft-caret"></i> <?=$type['name'];?></a>

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

                              </h4>
                            </div>
                            <div id="collapse1<?=$key;?>" class=" collapse" >
                              <div class="card-body">
                                <ul class="list-group list-group-flush">
                                  <?php $i=1; foreach ($auth->documents->where('document_type', $key) as $key => $doc) :?>
                                    <li class="list-group-item"><?=$i;?>) <?=$doc->DisplayStatus;?>  <a href="<?=domain;?>/<?=$doc->path;?>" target="_blank" class="float-right">Open</a><br>
                                      <!-- <small>hyuu uho i</small> -->
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
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
