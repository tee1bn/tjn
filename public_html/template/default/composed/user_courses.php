

                                 <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                                     <tbody>

                                       <?php foreach ($user->enrolled_courses() as $course):?>

                                       <tr>
                                         <td style="padding: 2px;">
                                           <div class="col-xl-12 col-lg-12" style="padding: 0px;">
                                             <div class="alert bg-dark  alert-dismissible mb-2" role="alert">
                                               <strong class="float-"><?=$course->title;?></strong><br>
                                               <small>Instructor: <?=$course->Instructor->lastname;?> <?=$course->Instructor->firstname;?>
                                                </small>
                                                <br>
                                               <!-- <span class="float-right">
                                                 <a href="<?=domain;?>/courses/<?=$course->id;?>/access/<?=$this->encode_for_url($course->title);?>"><span class="btn btn-sm btn-primary">
                                                  <i class="ft ft-unlock"></i> Open</span></a>
                                               </span> -->
                                               <br/>
                                             </div>
                                           </div>

                                         </td>
                                       </tr>
                                       <?php endforeach;?>
                                     </tbody>
                                   
                                 </table>
