                    
                    <?php

                        $ticket_code = $_GET['ticket_id'];

                        $ticket =  SupportTicket::where('code', $ticket_code)->first();


                        if ($ticket==null) {
                            $link = \Config::domain()."/contacts";
                            Redirect::to($link); 

                            die();
                        }



                        if ($this->admin()) {

                          $action = \Config::domain()."/ticket_crud/admin_response";
                        }else{
                          $action = \Config::domain()."/home/support_message";
                        }

                    ;?>

                  <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
                    <div class="card col-12" style="width: 100px;">
                      <div class="card-footer row">
                            <div class="col-sm-8  table-">
                                    <span class="media-heading">
                                        
                                        <?=$ticket->customer_name;?><br>

                                        <small class="">Email: <a href="mailto://<?=$ticket->customer_email;?>"><?=$ticket->customer_email;?></a></small><br>
                                        <small class="">Phone: <a href="tel://<?=$ticket->customer_phone;?>"><?=$ticket->customer_phone;?></a></small><br>
                                    </span>
                                    <p style="background: #3737391f;padding: 5px;"><small>
                                        <?=$ticket->subject_of_ticket;?> 
                                    </small>
                                    </p>
                            </div>
                             <div class="col-sm-4 ">
                                    <small class="float-right">Ticket ID: <?=$ticket->code;?><?=$ticket->displayStatus;?></small><br>
                                    <small class="float-right"> <?=$ticket->created_at->format('M j, Y g:i A');?></small><br>
                                    <small class="float-right"><?=$ticket->closeButton;?></small><br>
                                </div>         
                          
                      </div>
                      <div class="card-footer">

                        <div class="row"  style="max-height: 350px; overflow-y: scroll;">

                                <?php  foreach ($ticket->messages as $message) :
                                  if ($message->admin == null) {
                                      $color = "#e7e7e7";
                                      $name = $ticket->customer_name;
                                  }else{
                                      $name = $message->admin->firstname;
                                      $color = "#37373933";

                                  }
                                  ?>
                                <div class="col-md-12">
                                    <div class=" table-bordered" style="padding: 5px;overflow: inherit;background: <?=$color;?>;">
                                        <div class="col-md-12">
                                            
                                        <img class="pull-left" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png" class="-object" style="width:20px"> <?=$name;?>
                                    <small class="float-right"><i class="fa fa-calendar"></i> <?=$message->created_at->format('M j, Y g:i A');?>
                                    </small>
                                        <small class="pull-left">

                                            <?=$message->attachments;?>
                                             &nbsp; &nbsp;
                                        </small>
                                        </div>

                                      <div class="-body" style="padding-left: 15px;">
                                        <p><?=$message->message;?></p>
                                      </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            </div>

                          
                      </div>
                      <div class="card-footer">
                          <form method="POST" action="<?=$action;?>" enctype="multipart/form-data">
                              <textarea id="editor1" class="form-control" required=""
                               name="message" rows="4" placeholder="Enter Your Message"></textarea>
                                   <br>

                                  <input type="hidden" required="" name="ticket_code" value="<?=$ticket->code;?>">
                                  <input type="hidden" name="action" value="submit_message">
                                  <input style="display:none ;" 
                                  type="file" onchange="update_screen(this);" name="documents[]" id="documents" multiple="">
                                  <span id="no_of_documents">0 file(s)</span>

                                  <div class="btn-group">
                                    <button type="button"
                                     onclick="document.getElementById('documents').click();"
                                     class="btn btn-secondary">File</button>
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                  </div>

                          </form>
                      </div>
                    </div>


                    <?php if ($this->admin()) :?>
                      <script>
                          CKEDITOR.replace('editor1');
                      </script>
                    <?php endif ;?>

                    <script>
                        update_screen = function($file_input){
                                document.getElementById('no_of_documents').innerHTML = `${$file_input.files.length} file(s)`;
                        }
                        
                    </script>

