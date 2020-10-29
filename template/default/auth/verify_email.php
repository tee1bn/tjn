<?php
$page_title = "Verify Email";
include 'includes/auth_header.php';?>


<script>
     
    function send_verification_email() {
        if( window.$ ) {
                // do your action that depends on jQuery.  
          $.ajax({
              type: "POST",
              url: "<?=domain;?>/register/verify_email",
              cache: false,
              success: function(response) {
                    window.notify();
                },
                error: function(response) {}
            });

            $("#spiner").html('<i class="fa fa-spinner fa-spin"></i>');
        } else {
                // wait 50 milliseconds and try again.
                window.setTimeout( send_verification_email, 1000 );
        }
    }
    send_verification_email();
</script>
 




                    <center style="padding:10px;" class="">* Verify your email</center>
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
 					Hi <b><?=$auth->fullname;?> (<?=$auth->username;?>)</b><br>
						<p>
  						

						We have sent you a confirmation email. Kindly check your inbox.</p>

              <form action="<?=domain;?>/register/verify_email" method="POST" class="ajax_form">
                
							<button  type="submit" class="btn btn-lg btn-block">Resend</button>
              </form>
					</div>


                 


					<p class="text-center">Don't have an account? <a href="<?=domain;?>/register" class="card-link">Register</a> Or <a href="<?=domain;?>/login">Login</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
<?php include 'includes/auth_footer.php';